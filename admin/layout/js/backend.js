// JavaScript Document
/*global $, confirm */



$(function(){
	

	'use strict';
	
	$('[placeholder]').focusin(function(){
		
		$(this).attr('data-text',$(this).attr('placeholder'));
		
		$(this).attr('placeholder','');
		
	}).blur(function(){
		
		$(this).attr('placeholder', $(this).attr('data-text'));
		
	});
	
	//Add Asterisk On Required Field
	
	$('input').each(function(){
		
		if ($(this).attr('required') === 'required'){
			$(this).after('<span class="asterisk">*</span>');
		}
		
	});
	
	var passField = $('.password');
	
	$('#show-pasword').hover(function(){
		passField.attr('type', 'text');
	}, function(){
		passField.attr('type', 'password');
	});
	var passFile = $('.pass');
	
	$('#show-pasword2').hover(function(){
		passFile.attr('type', 'text');
	}, function(){
		passFile.attr('type', 'password');
	});
	
	$('.confirm').click(function(){
		
		return confirm('Are You Sure?');
	});



	
});

















