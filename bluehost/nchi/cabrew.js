function calcTarget(mmdd){
	var one_day=1000*60*60*24; //Set 1 day in milliseconds
	var arr_moda = mmdd.split("/");
	// subtracting 1 from the month cause javascript is stupid that way.
	arr_moda[0]--;
	var today=new Date();
	var target=new Date(today.getFullYear(), arr_moda[0], arr_moda[1]);
	if (today.getMonth()>arr_moda[0] || (today.getMonth()==arr_moda[0] && today.getDate()>arr_moda[1])) {
		//if day has passed already calculate until next year
		target.setFullYear(target.getFullYear()+1);
	}
	//Calculate difference btw the two dates, and convert to days
	return Math.ceil((target.getTime()-today.getTime())/(one_day));
}
