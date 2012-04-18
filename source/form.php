<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>VTS Registration Form</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js.js"></script>
<script type="text/javascript">
    $(function() 
    {
        $("ul li:first").show();
        var ck_username = /^[A-Za-z0-9_]{5,20}$/;
        var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i 
        var ck_password =  /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/;
        var ck_phone = /^[0-9-]{10,20}$/;
	var ck_country=/^\s$/;
	var ck_imei=/^[0-9-]{10,20}$/;
        $('#username').keyup(function()
        {
            var username=$(this).val();
            if (!ck_username.test(username)) 
            {
                $(this).next().show().html("Minimum 5 characters");
            }
            else
            {
                $(this).next().hide();
                $("li").next("li.imei").slideDown({duration: 'slow',easing: 'easeOutElastic'});
            }
        });

	/* $('#country').keyup(function()
        {
            var country=$(this).val();
            if (!ck_country.test(country)) 
            {
                $(this).next().show().html("Enter valid country");
            }
            else
            {
                $(this).next().hide();
                $("li").next("li.phone").slideDown({duration: 'slow',easing: 'easeOutElastic'});
            }
        });*/

     /*   $('#password').keyup(function()
        {
            var password=$(this).val();
            if (!ck_password.test(password)) 
            {
                $(this).next().show().html("Minimum 6 Characters");
            }
            else
            {
                $(this).next().hide();
                $("li").next("li.email").slideDown({duration: 'slow',easing: 'easeOutElastic'});
            }
        });
        $('#email').keyup(function()
        {
            var email=$(this).val();
            if (!ck_email.test(email)) 
            {
                $(this).next().show().html("Enter valid email");
            }
            else
            {
                $(this).next().hide();
                $("li").next("li.phone").slideDown({duration: 'slow',easing: 'easeOutElastic'});
            }
        });*/
	      $('#imei').keyup(function()
        {
            var imei=$(this).val();
            if (!ck_imei.test(imei)) 
            {
                $(this).next().show().html("Minimum 10 numbers");
            }
            else
            {
                $(this).next().hide();
                $("li").next("li.phone").slideDown({duration: 'slow',easing: 'easeOutElastic'});
            }
        });
        $('#phone').keyup(function()
        {
            var phone=$(this).val();
            if (!ck_phone.test(phone)) 
            {
                $(this).next().show().html("Minimum 10 numbers");
            }
            else
            {
                $(this).next().hide();
                $("li").next("li.country").slideDown({duration: 'slow',easing: 'easeOutElastic'});
            }
        });

	  $('#country').keyup(function()
        {
            var country=$(this).val();
		console.log(country);
            if (!ck_country.test(country)) 
            {
                $(this).next().show().html("select valid country");
            }
            else
            {
                $(this).next().hide();
                $("li").next("li.submit").slideDown({duration: 'slow',easing: 'easeOutElastic'});
            }
        });
        
        $('#submit').click(function()
        {
            var email=$("#email").val();
            var username=$("#username").val();
            var password=$("#password").val();
            if(ck_email.test(email) && ck_username.test(username) && ck_password.test(password) )
            {
                $("#form").show().html("<h1>Thank you!</h1><p>You have registered successfully</p>");
            }
            return false;
        });
    })
</script>

<style>
    body
    {
        font-family:Arial, Helvetica, sans-serif
    }
    h1, h2
    {
        font-family:'Georgia', Times New Roman, Times, serif;
    }
    h2
    {
        color:#999;
    }
    ul
    {
        padding:0px;
        margin:0px;
        list-style:none;
    }
    li
    {
        padding:5px;
        display:none;
    }
    label
    {
        font-size:14px;
        font-weight:bold;
    }
    input[type="text"], input[type="password"]
    {
        -moz-border-radius: 6px 6px 6px 6px;
        -moz-box-shadow: 3px 5px 10px #78D8F2;
        border: 1px solid #05BBED;
        font-size: 15px;
        margin: 8px;
        padding: 6px;
        width: 220px;
    }
    input[type="submit"]
    {
        background-color: #078EA0;
        border: 1px solid #0094A7;
        color: #FFFFFF;
        font-size: 14px;
        padding: 4px;
        -moz-border-radius:6px;
        -webkit-border-radius:6px;

    }
    .error
    {
        font-size:11px;
        color:#cc0000;
        padding:4px;
    }

    #form
    {
        width:415px;
        margin:0 auto;
        margin-top:30px;
    }
    #form-elements {
        border: 1px solid #aeaeae;
        background-color: #F2F2F2;
        padding: 14px;
    }
</style>
<script>jQuery(function($) {
        $.getJSON('gmt.php', function(json) {
                var select = $('#country');
 
                $.each(json.Result.Data, function(i, v) {
			var loc=String(v.Location);
			var temp=new Array();
			temp=loc.split(",");
			
			for(j=0;j<temp.length;j++)
			{
                        var option = $('<option />');
			

                        option.attr('value', v.gmt_id)
                              .html("<div style='clear: both;'><p style='float:left;'>"+temp[j]+"</p><p style='float:right;'>"+v.gmt+"</p></div>")
                              .appendTo(select);
			}
                });
        });
});</script>
</head>

<body>



<div id="form">
<h2>VTS registration form</h2>
<form method="post" id="form-elements" >
<ul>
<li class="username">
<label>Device Name: </label><br/> 
<input type="text" name="name" id="username" />
<span class="error"></span>
</li>
<!--<li class="password">
<label>Password: </label><br/> 
<input type="password" name="password" id="password" />
<span class="error"></span>
</li>
<li class="email">
<label>Email: </label><br/> 
<input type="text" name="email" id="email" />
<span class="error"></span>
</li>-->
<li class="imei">
<label>Imei No.: </label><br/> 
<input type="text" name="imei" id="imei" />
<span class="error"></span>
</li>
<li class="phone">
<label>Mobile No: </label><br/> 
<input type="text" name="phone" id="phone" />
<span class="error"></span>
</li>

<li class="country">
<label>Country: </label><br/> 
<!--<input type="text" name="country" id="country" />-->
<select name="country" id="country">
<option value="">Select your country</option>
</select>
<span class="error"></span>
</li>
<li class="submit">
<input type="submit" value=" Register " id='submit'/>
</li>
</ul>
</form>
</div>


</body>
</html>
