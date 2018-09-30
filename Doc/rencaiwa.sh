#!/bin/sh

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
bin=${DIR}/../bin
lib=${DIR}/../lib

echo "
{
    \"type\" : \"jdbc\",
    \"jdbc\" : {
        \"url\" : \"jdbc:postgresql://192.168.6.24:5432/fjl_resume\",
        \"user\" : \"postgres\",
        \"password\" : \"5432@pk_id\",
        \"sql\":\"SELECT resume_id AS _id,resume_id,person as person_id,gender,birthday,EXTRACT (epoch FROM birthday) AS birthday_timestamp,current_city,job_intension ->> 'job' AS hope_job,job_intension ->> 'trade' AS hope_trade, to_number( job_intension -> 'salary' ->> 'from', '999999999') AS salary_from,to_number( job_intension -> 'salary' ->> 'to', '999999999') AS salary_to,job_intension ->> 'city' AS hope_city,EXTRA #>> '{work, job}' AS last_job,CONCAT (TRIM (TRIM (job_intension ->> 'job', '['),']'),',',EXTRA #>> '{work, job}') AS intention_job_work_job,EXTRA #>> '{work, trade}' AS current_trade,EXTRA #>> '{work, company}' AS last_company,SUBSTRING (((WORK :: json -> (json_array_length (WORK :: json) - 1)) :: json ->> 'stime'),0,5) AS first_work_time,(WORK :: json -> (json_array_length (WORK :: json) - 1)) :: json ->> 'stime' AS first_work_date,degree_id,EXTRA #>> '{edu, school}' AS top_degree_school,EXTRA #>> '{edu, speciality}' AS top_degree_major,update_time, contact ->> 'name' AS NAME,contact ->> 'mobile' AS mobile,contact ->> 'email' AS email,picture, CONCAT (CASE WHEN WORK -> 'job_description' = NULL THEN '' ELSE fjl.get_row_agg (WORK, '{job_description}') END,CASE WHEN project -> 'description' = NULL THEN ''ELSE fjl.get_row_agg (project, '{description}') END ) AS work_and_project_description, refresh_time AS resume_update_time,to_char(to_timestamp(refresh_time),'YYYY-MM-DD') AS resume_update_day,CONCAT ( fjl.get_row_agg (education, '{school}'),fjl.get_row_agg (education, '{speciality}'),fjl.get_row_agg (education, '{description}'),fjl.get_row_agg (training, '{agency}'),fjl.get_row_agg (skill, '{skill}'),fjl.get_row_agg (certification, '{cer_name}'), fjl.get_row_agg (certification,'{description}'),fjl.get_row_agg (training, '{course}'),fjl.get_row_agg (LANGUAGE, '{language}'),fjl.get_row_agg (project, '{duty}'), fjl.get_row_agg (project, '{description}')) AS text_str_keywords FROM fjl.resume WHERE resume_id > 0 AND degree_id >4 AND degree_id <>10  AND education IS NOT NULL AND ( work IS NOT NULL OR project IS NOT NULL ) AND update_time > (NOW() - INTERVAL '14 day')\",
        \"elasticsearch\" : {
            \"cluster\" : \"uutuijian\",
            \"host\": \"localhost\",
            \"port\": 9300
        },
        \"index\": \"rencaiwa\",
        \"type\": \"customer\",
        \"ignore_null_values\": true,
        \"treat_binary_as_string\" : true,
        \"max_bulk_actions\" : 20000,
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
