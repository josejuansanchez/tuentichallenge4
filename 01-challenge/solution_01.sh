#!/bin/bash

// José Juan Sánchez Hernández
// @josejuansanchez

FILE=students
SORTED_FILE=students_sorted_file

# Sort the file using the given column number: 
# 4 (studies), 5 (academic_year), 3 (age), 2 (gender), 1 (name)
sort -t "," -k4 -k5 -k3 -k2 -k1 $FILE > $SORTED_FILE

# Read the total number of test
read num

# Read all the cases
for (( i=1; i<=$num; i++ ))
do
   read line
   result=`grep "$line" $SORTED_FILE | cut -d"," -f1`

   if [ -z "$result" ]; then
   	echo "Case #$i: NONE"
   else
   	echo "Case #$i: $result" > temp.txt
   	paste -s -d ',' temp.txt 
   fi
done