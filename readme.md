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