Extract Schema

mdb-schema -T Customer_Master Wincc_batch.mdb mysql

Export to csv

mdb-export Wincc_batch.mdb Customer_Master > Customer_Master.csv

Import 

mysqlimport --delete --fields-optionally-enclosed-by='"' --ignore-lines=1 --fields-terminated-by=, --local -u root -psecret bb_plant_1 Customer_Master.csv