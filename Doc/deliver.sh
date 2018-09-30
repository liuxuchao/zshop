#!/bin/sh

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
bin=${DIR}/../bin
lib=${DIR}/../lib

echo "
{
    \"type\" : \"jdbc\",
    \"jdbc\" : {
        \"url\" : \"jdbc:mysql://192.168.6.171:3306/deliver?useSSL=false\",
        \"user\" : \"root\",
        \"password\" : \"uutuijian1qaz\",
        \"sql\":\"SELECT id AS _id,resume_id,person_id,name,mobile,email,company_name,position_name AS job,location_str AS city,trade_name,resume_update AS resume_update_time,deliver_time FROM deliver_info WHERE person_id NOT IN ('0', 'NA')\",
        \"elasticsearch\" : {
            \"cluster\" : \"uutuijian\",
            \"host\": \"localhost\",
            \"port\": 9300
        },
        \"index\": \"deliver\",
        \"type\": \"customer\",
        \"ignore_null_values\": true,
        \"treat_binary_as_string\" : true,
        \"max_bulk_actions\" : 5000,
        \"max_concurrent_bulk_requests\" : 10,
        \"metrics\" : {
            \"enabled\" : true
        }
    }
}
"  | java \
    -cp "${lib}/*" \
    -Dlog4j.configurationFile=${bin}/log4j2.xml \
    org.xbib.tools.Runner \
    org.xbib.tools.JDBCImporter
