Extract Schema

mdb-schema -T Customer_Master Wincc_batch.mdb mysql

Export to csv

cp /home/Wincc_batch.mdb export/
cd /home/export
mdb-export Wincc_batch.mdb Customer_Master > Customer_Master.csv
mdb-export Wincc_batch.mdb Batch_Dat_Trans > Batch_Dat_Trans.csv
mdb-export Wincc_batch.mdb Batch_Transaction > Batch_Transaction.csv

Import 

mysqlimport --delete --fields-optionally-enclosed-by='"' --ignore-lines=1 --fields-terminated-by=, --local -u root -psecret bb_plant_1 Customer_Master.csv

perl -i -ple 's/\s+$//' Batch_Dat_Trans.csv

sed -i -e 's/Adm2_Target2 /Adm2_Target2/g' /home/forge/SBMS1/Batch_Dat_Trans.csv

scp forge@139.59.71.171:/home/forge/SBMS1/* ~/Desktop/.


SBMS1
1. Create Tables from schema.md


mysqlimport --delete --fields-optionally-enclosed-by='"' --ignore-lines=1 --fields-terminated-by=, --local -u root -psecret bb_analytics Batch_Dat_Trans.csv



bb-analytics.test/batch-api?batchingPlantId=TRISHUL1&fromDate=2018-11-03&toDate=2018-11-03&all=true