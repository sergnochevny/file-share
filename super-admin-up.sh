#!/bin/bash

./yii protus/add-role superAdmin admin
./yii protus/create-user sadmin:sadmin@example.com:12345678:superAdmin
