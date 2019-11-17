import numpy as np
import cv2
from pathlib import Path
import imutils
import time
from sklearn.cluster import KMeans
from collections import Counter
from colormath.color_objects import sRGBColor, LabColor
from colormath.color_conversions import convert_color
from colormath.color_diff import delta_e_cie2000
import sys

prev_centroid = None
calculate_dist = False


def get_dominant_color(image, k=4, image_processing_size=None):
    """
    takes an image as input
    returns the dominant color of the image as a list

    dominant color is found by running k means on the
    pixels & returning the centroid of the largest cluster

    processing time is sped up by working with a smaller image;
    this resizing can be done with the image_processing_size param
    which takes a tuple of image dims as input

    >>> get_dominant_color(my_image, k=4, image_processing_size = (25, 25))
    [56.2423442, 34.0834233, 70.1234123]
    """
    # resize image if new dims provided
    if image_processing_size is not None:
        image = cv2.resize(image, image_processing_size,
                           interpolation=cv2.INTER_AREA)

    # reshape the image to be a list of pixels
    image = image.reshape((image.shape[0] * image.shape[1], 3))

    # cluster and assign labels to the pixels
    clt = KMeans(n_clusters=k)
    labels = clt.fit_predict(image)

    # count labels to find most popular
    label_counts = Counter(labels)

    # subset out most popular centroid
    dominant_color = clt.cluster_centers_[label_counts.most_common(1)[0][0]]

    return list(dominant_color)


# if __name__ == '__main__':
def main(video_path):

    output_path = Path(video_path).parent / 'prediction.mp4'

    print('[INFO] Output path: ', output_path)

    yolo_path = Path(__file__).parent.parent / 'yolo-coco'
    labels_path = yolo_path / 'coco.names'

    print('[INFO] Parent: ', Path(__file__).parent)
    print('[INFO] Yolo path: ', yolo_path)

    # video_path = Path(__file__).parent / 'videos' / 'to_plane.mp4'
    # output_path = Path(__file__).parent / 'videos' / 'to_plane_detection.mp4'

    confidence = 0
    threshold = 0.5

    labels = open(labels_path).read().strip().split("\n")

    # initialize a list of colors to represent each possible class label
    np.random.seed(42)
    colors = np.random.randint(0, 255, size=(len(labels), 3),
                               dtype="uint8")

    # derive the paths to the YOLO weights and model configuration
    weightsPath = yolo_path / 'yolov3.weights'
    configPath = yolo_path / 'yolov3.cfg'

    # load our YOLO object detector trained on COCO dataset (80 classes)
    # and determine only the *output* layer names that we need from YOLO
    net = cv2.dnn.readNetFromDarknet(str(configPath), str(weightsPath))
    ln = net.getLayerNames()
    ln = [ln[i[0] - 1] for i in net.getUnconnectedOutLayers()]

    # initialize the video stream, pointer to output video file, and
    # frame dimensions
    vs = cv2.VideoCapture(str(video_path))
    writer = None
    (W, H) = (None, None)

    # try to determine the total number of frames in the video file
    try:
        prop = cv2.cv.CV_CAP_PROP_FRAME_COUNT if imutils.is_cv2() \
            else cv2.CAP_PROP_FRAME_COUNT
        total = int(vs.get(prop))
        print("[INFO] {} total frames in video".format(total))

    # an error occurred while trying to determine the total
    # number of frames in the video file
    except:
        print("[INFO] could not determine # of frames in video")
        print("[INFO] no approx. completion time can be provided")
        total = -1

    first_detection = False

    # loop over frames from the video file stream
    while True:
        # read the next frame from the file
        (grabbed, frame) = vs.read()

        # if the frame was not grabbed, then we have reached the end
        # of the stream
        if not grabbed:
            break
        # if the frame dimensions are empty, grab them
        if W is None or H is None:
            # frame = rescale_frame(frame, percent=150)
            (H, W) = frame.shape[:2]

        # construct a blob from the input frame and then perform a forward
        # pass of the YOLO object detector, giving us our bounding boxes
        # and associated probabilities
        blob = cv2.dnn.blobFromImage(frame, 1 / 255.0, (416, 416),
            swapRB=True, crop=False)
        net.setInput(blob)
        start = time.time()
        layerOutputs = net.forward(ln)
        end = time.time()

        # initialize our lists of detected bounding boxes, confidences,
        # and class IDs, respectively
        boxes = []
        confidences = []
        classIDs = []

        # loop over each of the layer outputs
        for output in layerOutputs:
            # loop over each of the detections
            for detection in output:
                # extract the class ID and confidence (i.e., probability)
                # of the current object detection
                scores = detection[5:]
                classID = np.argmax(scores)
                conf = scores[classID]

                # filter out weak predictions by ensuring the detected
                # probability is greater than the minimum probability
                if conf > confidence:
                    # scale the bounding box coordinates back relative to
                    # the size of the image, keeping in mind that YOLO
                    # actually returns the center (x, y)-coordinates of
                    # the bounding box followed by the boxes' width and
                    # height
                    box = detection[0:4] * np.array([W, H, W, H])
                    (centerX, centerY, width, height) = box.astype("int")

                    # use the center (x, y)-coordinates to derive the top
                    # and and left corner of the bounding box
                    x = int(centerX - (width / 2))
                    y = int(centerY - (height / 2))

                    # update our list of bounding box coordinates,
                    # confidences, and class IDs
                    boxes.append([x, y, int(width), int(height)])
                    confidences.append(float(conf))
                    classIDs.append(classID)

        # apply non-maxima suppression to suppress weak, overlapping
        # bounding boxes
        idxs = cv2.dnn.NMSBoxes(boxes, confidences, confidence, threshold)

        # ensure at least one detection exists
        min_distance = 100000
        if len(idxs) > 0:
                for i in idxs.flatten():
                    # extract the bounding box coordinates
                    (x, y) = (boxes[i][0], boxes[i][1])
                    (w, h) = (boxes[i][2], boxes[i][3])

                    already_detected = False

                    area = w * h

                    # draw a bounding box rectangle and label on the frame
                    color = [int(c) for c in colors[classIDs[i]]]
                    # if labels[classIDs[i]] == 'truck' or labels[classIDs[i]] == 'motorbike' or labels[classIDs[i]] == 'car':
                    #     color = [0, 0, 255]
                    #     if area < 3000:
                    #         cv2.rectangle(frame, (x, y), (x + w, y + h), color, 2)
                    #         text = "suitcase: {:.4f} Costumer's suitcase".format(confidences[i])
                    #         cv2.putText(frame, text, (x, y - 5),
                    #                     cv2.FONT_HERSHEY_SIMPLEX, 0.5, color, 2)
                    #         already_detected = True
                    #         first_detection = True
                    #         prev_x = x
                    #         prev_y = y
                    #         prev_w = w
                    #         prev_h = h

                    if classIDs[i] == 28: # suitcase label

                        suitcase = frame[y:y + h, x:x + w, :]
                        dominant_color = get_dominant_color(suitcase, 4, (25, 25))
                        dominant_color = [int(dominant_color[0]), int(dominant_color[1]), int(dominant_color[2])]
                        # print(dominant_color)

                        # # print(i, distance)

                        # Red Color
                        color1_rgb = sRGBColor(int(dominant_color[0])/255, int(dominant_color[1])/255, int(dominant_color[2])/255)

                        # Blue Color
                        color2_rgb = sRGBColor(1.0, 1.0, 1.0)

                        # Convert from RGB to Lab Color Space
                        color1_lab = convert_color(color1_rgb, LabColor)

                        # Convert from RGB to Lab Color Space
                        color2_lab = convert_color(color2_rgb, LabColor)

                        # Find the color difference
                        distance = delta_e_cie2000(color1_lab, color2_lab)

                        if distance < 20:
                            color = [0, 0, 255]

                            text = "{}: {:.4f} Costumer's suitcase".format(labels[classIDs[i]], confidences[i])

                        else:
                            text = "{}: {:.4f}".format(labels[classIDs[i]], confidences[i])

                        cv2.rectangle(frame, (x, y), (x + w, y + h), color, 2)

                        cv2.putText(frame, text, (x, y - 5),
                            cv2.FONT_HERSHEY_SIMPLEX, 0.5, color, 2)

                    if labels[classIDs[i]] == 'person':
                        person = frame[y:y + h, x:x + w]
                        # apply a gaussian blur on this new recangle image
                        person = cv2.GaussianBlur(person, (23, 23), 30)
                        # merge this blurry rectangle to our final image
                        frame[y:y + h, x:x + w] = person

        # check if the video writer is None
        if writer is None:
            # initialize our video writer
            fourcc = cv2.VideoWriter_fourcc(*"mp4v")
            writer = cv2.VideoWriter(str(output_path), fourcc, 30,
                (frame.shape[1], frame.shape[0]), True)

            # some information on processing single frame
            if total > 0:
                elap = (end - start)
                print("[INFO] single frame took {:.4f} seconds".format(elap))
                print("[INFO] estimated total time to finish: {:.4f}".format(
                    elap * total))

        # write the output frame to disk
        writer.write(frame)

    # release the file pointers
    print("[INFO] cleaning up...")
    writer.release()
    vs.release()