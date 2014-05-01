#!/bin/bash

# Count the number of occurrences
grep -c 54936654 phone_call.log 

function get_contacts() {
	ID=$1
	# Get the contacts of an ID
	contacts=`grep $1 phone_call.log | awk '{print $1 "\n" $2}' | sort | uniq | grep -v $1`
	echo $contacts
}

#ID=54936654
ID=167647122
echo "ID: $ID"
get_contacts $ID