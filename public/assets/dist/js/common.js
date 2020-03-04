function ajax_find_user() {
	tableUsers
	$("#tableUsers tbody tr").remove();
	quest = $("input[name='quest']").val();
	url = "https://lk.pulsauto.ru/api/user/get?q="+quest;
	$.ajax({
		url: url,
	})
	.done(function(data) {

		obj = $.parseJSON(data);
		$.each( obj, function( key, value ) {
			console.log(value)
			html = '<tr><td>'+value.id+'</td><td>'+value.name+'</td><td><a onclick="selectUser('+value.id+', \''+value.name+'\')">Выбрать</a></td></tr>'
			$('#tableUsers tbody').append(html);
		});
		
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	
 	console.log(url);
}

function selectUser(id, name) {
	//console.log(id + " " + name);
	$("#selectUser").empty()
	$("input[name='student']").val(name);
	$("#selectUser").append(name);
	$("#myModal").modal('hide');
}

//Работа с формой


$('.header__menu-burger').click(function() {
    $('body').removeClass('mobile-menu--closed');
    $('body').addClass('mobile-menu--opened');
});

$('.mobile-menu__header-close-button').click(function() {
    $('body').removeClass('mobile-menu--opened');
    $('body').addClass('mobile-menu--closed');
});

email = /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/i;;
phone = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;
fio = /^[А-ЯA-Z][а-яa-zА-ЯA-Z\-]{0,}\s[А-ЯA-Z][а-яa-zА-ЯA-Z\-]{1,}(\s[А-ЯA-Z][а-яa-zА-ЯA-Z\-]{1,})?$/;

function registerForm() {
	var form = document.forms.register;
	if(validForm(form))
	{
		form.submit();
	}
}


function validForm(form) {
	if( validElement('email')  &&
		validElement('phone') &&
		validElement('fio')   &&
		stateCheck())
	{
		return true;
	}else{
		validElement('email');
		validElement('phone');
		validElement('fio');
		stateCheck();
	}
}

function validElement(name) {
	var form = document.forms.register;
	switch(name) {
		case 'email':
		  	var elems = form.elements.email;
		    if(!email.test(elems.value)){
				elems.parentElement.classList.add('registr__form-group-error');
			}else{
				elems.parentElement.classList.remove('registr__form-group-error');
			}
			return email.test(elems.value);
	  	case 'phone':
		  	var elems = form.elements.phone;
		    if(!phone.test(elems.value)){
				elems.parentElement.classList.add('registr__form-group-error');
			}else{
				elems.parentElement.classList.remove('registr__form-group-error');
			}
		    return phone.test(elems.value);
	  	case 'fio':
		  	var elems = form.elements.fio;
		    if(!fio.test(elems.value)){
				elems.parentElement.classList.add('registr__form-group-error');
			}else{
				elems.parentElement.classList.remove('registr__form-group-error');
			}
		    return fio.test(elems.value);
	  	default:
	    	break;
	}
}

function stateCheck()
{
	var form = document.forms.register;
	var elems = form.elements.check;
	if (elems.checked)
	{
		elems.parentElement.classList.remove('registr__form-group-error');
		return true;
	}
	else 
	{
		elems.parentElement.classList.add('registr__form-group-error');
		return false;
	}
	return false;
}