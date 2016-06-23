
//jquery.validate Form Validation
$(document).ready(function(){
	//Login Form Validation
	$("#loginFormCN").validate({
		rules:{
			usernameCN:{
				required:true,
				minlength:3,
				maxlength:32,
			},
			passwordCN:{
				required:true,
				minlength:3,
				maxlength:32,
			},
		},
		//Error message prompt.
		messages:{
			usernameCN:{
				required:"<div style='color:red;'>请输入用户名</div>",
				minlength:"<div style='color:red;'>请输入3-32位字符</div>",
				maxlength:"<div style='color:red;'>请输入3-32位字符/div>",
				remote: "<div style='color:red;'>用户名已被注册</div>",
			},
			passwordCN:{
				required:"<div style='color:red;'>请输入密码</div>",
				minlength:"<div style='color:red;'>请输入正确的密码</div>",
				maxlength:"<div style='color:red;'>请输入正确的密码</div>",
			},
		},

	});
	$("#loginFormEN").validate({
		rules:{
			usernameEN:{
				required:true,
				minlength:3,
				maxlength:32,
			},
			passwordEN:{
				required:true,
				minlength:3,
				maxlength:32,
			},
		},
		//Error message prompt.
		messages:{
			usernameEN:{
				required:"<div style='color:red;'>Please fill in the user name.</div>",
				minlength:"<div style='color:red;'>Should enter 3-32 characters.</div>",
				maxlength:"<div style='color:red;'>Should enter 3-32 characters.</div>",
				remote: "<div style='color:red;'>User name already exists.</div>",
			},
			passwordEN:{
				required:"<div style='color:red;'>Please fill in the password.</div>",
				minlength:"<div style='color:red;'>Please enter the correct password.</div>",
				maxlength:"<div style='color:red;'>Please enter the correct password.</div>",
			},
		},

	});
	//Register Form Validation
	$("#registerFormCN").validate({
		rules:{
			usernameCN:{
				required:true,
				minlength:3,
				maxlength:32 
			},
			passwordCN:{
				required:true,
				minlength:3,
				maxlength:32,
			},
			emailCN:{
				required:true,
				email:true,
			},
			confirm_passwordCN:{
				required:true,
				minlength:3,
				equalTo:'.password'
			},
		},
		//Error message prompt.
		messages:{
			usernameCN:{
				required:"<div style='color:red;'>请输入用户名</div>",
				minlength:"<div style='color:red;'>3-32位字符，支持汉字、字母、数字等</div>",
				maxlength:"<div style='color:red;'>3-32位字符，支持汉字、字母、数字等</div>",
				remote: "<div style='color:red;'>用户名已被注册</div>",
			},
			passwordCN:{
				required:"<div style='color:red;'>请输入密码</div>",
				minlength:"<div style='color:red;'>3-32位字符，建议由支持汉字、字母、数字组合</div> ",
				maxlength:"<div style='color:red;'>3-32位字符，建议由汉字、字母、数字组合</div>",
			},
			emailCN:{
				required:"<div style='color:red;'>请输入邮箱</div>",
				email: "<div style='color:red;'>请输入正确的邮箱地址</div>"
			},
			confirm_passwordCN:{
				required: "<div style='color:red;'>请再次输入密码</div>",
				minlength: "<div style='color:red;'>密码长度只能在3-12位之间</div>",
				equalTo: "<div style='color:red;'>两次输入密码不一致</div>",//与另一个元素相同
			},


		},
	});
	$("#registerFormEN").validate({
		rules:{
			usernameEN:{
				required:true,
				minlength:3,
				maxlength:32
			},
			passwordEN:{
				required:true,
				minlength:3,
				maxlength:32,
			},
			emailEN:{
				required:true,
				email:true,
			},
			confirm_passwordEN:{
				required:true,
				minlength:3,
				equalTo:'.password'
			},
		},
		//Error message prompt.
		messages:{
			usernameEN:{
				required:"<div style='color:red;'>Please fill in the user name.</div>",
				minlength:"<div style='color:red;'>Should enter 3-32 characters.</div>",
				maxlength:"<div style='color:red;'>Should enter 3-32 characters.</div>",
				remote: "<div style='color:red;'>User name already exists.</div>",
			},
			passwordEN:{
				required:"<div style='color:red;'>Please fill in the password.</div>",
				minlength:"<div style='color:red;'>Should enter 3-32 characters.</div> ",
				maxlength:"<div style='color:red;'>Should enter 3-32 characters.</div>",
			},
			emailEN:{
				required:"<div style='color:red;'>Please fill in the email.</div>",
				email: "<div style='color:red;'>Please enter a valid email address.</div>"
			},
			confirm_passwordEN:{
				required: "<div style='color:red;'>Please enter the same value again.</div>",
				minlength: "<div style='color:red;'>Confirm password can not be less than 3 characters.</div>",
				equalTo: "<div style='color:red;'>Please confirm your password again.</div>",//与另一个元素相同
			},


		},
	});
});
