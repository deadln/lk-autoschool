function checkbox_click(elem) {
	arr = document.getElementsByClassName('scales');
	for (var i = arr.length - 1; i >= 0; i--) {
		arr[i].checked = false;
	}
	elem.checked = true;

}