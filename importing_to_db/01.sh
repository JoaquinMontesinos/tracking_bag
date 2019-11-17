#!/bin/bash
set -e

echo $(date "+%Y-%m-%d %H:%M:%S") 
echo "Init file: "$0

##Customers
curl -X GET -H 'x-api-key: jmdSHjy6WPaXwoR75E6mJ1ImhxKPRJb51v6DBS0A' 'https://junction.dev.qoco.fi/api/customers'| jq -c  '.[]  | .[] | [.customerId,.name,.email,.phone,.target]  ' | tr -d '' | sed 's/[][]//g'  >> file_customer.csv
##Baggage
curl -X GET -H 'x-api-key: jmdSHjy6WPaXwoR75E6mJ1ImhxKPRJb51v6DBS0A' 'https://junction.dev.qoco.fi/api/events/01d5e96a-684c-48bd-afd9-9df0ebcb6c62'| jq -c  '.[]  | .[] | [.baggageId, .customerId,.rushbag,.special,.weight]  ' | tr -d '' | sed 's/[][]//g'  >> file_baggage.csv
##Events
curl -X GET -H 'x-api-key: jmdSHjy6WPaXwoR75E6mJ1ImhxKPRJb51v6DBS0A' 'https://junction.dev.qoco.fi/api/events/'$1| jq -c  '.[]  | .[] | [.eventId, .baggageId,.airport,.timestamp, .type]  ' | tr -d '' | sed 's/[][]//g'  >> file_events.csv