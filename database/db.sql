CREATE DATABASE JUNCTION2019;

CREATE TABLE "TravelMiss" (
  "id" int(11) NOT NULL AUTO_INCREMENT,
  "customerId" char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  "last_seen_date" datetime NOT NULL,
  "event" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  "last_seen_city" varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  "missing_bag_city" varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  "resolved" varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  "missing_bag_date" datetime DEFAULT NULL,
  "baggageId" char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "Events" (
  "eventId" char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  "baggageId" char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  "airport" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  "timestamp" datetime NOT NULL,
  "type" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY ("eventId")
);

CREATE TABLE "Customers" (
  "name" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  "email" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  "phone" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  "target" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY ("customerId")
);

CREATE TABLE "Baggage" (
  "baggageId" char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  "rushbag" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  "special" varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  "weight" double DEFAULT '0',
  PRIMARY KEY ("baggageId")
);
