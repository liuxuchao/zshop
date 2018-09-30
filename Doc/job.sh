#!/bin/sh

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
printf DIR
bin=${DIR}/../bin
lib=${DIR}/../lib

echo "
{
    \"type\" : \"jdbc\",
    \"jdbc\" : {
        \"url\" : \"jdbc:mysql://192.168.6.192:6033/uu_recommend?useSSL=false\",
        \"user\" : \"root\",
        \"password\" : \"uutuijian1qaz\",
        \"sql\":\"SELECT id AS _id,id, user_id,channel_type,channel_id,original_id,original_publish_status,is_recommend,name,short_name,job_trade,salary,salary_from,salary_to,work_address,work_years,work_years_from,work_years_to,degree,refresh_time,refresh_end_time,job_description,company_name,company_size,company_size_from,company_nature,company_trade,recommended_time,create_time,update_time,work_address_detail,city,district,is_default,default_recommend,is_top FROM uu_channel_jobs\",
        \"elasticsearch\" : {
            \"cluster\" : \"uutuijian\",
            \"host\": \"localhost\",
            \"port\": 9300
        },
        \"index\": \"uu_tuijian_job\",
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