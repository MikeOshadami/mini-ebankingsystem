$('document').ready(function()
{ 

$("#submit").attr("disabled",true);

$('#amount').on("keypress keyup blur",function (event) {
     $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
		
  $('#accountNumber').on('keypress keyup', function(event) {
	$(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
			var value = $(this).val();
			var interbank = $('#interbank').val();
			if(interbank == '1'){
				var bankCode = "003";
				}
			else {
			var bankCode = $('#bankCode').val();
			}
	 console.log(bankCode);
    if (value.length < 10)
	$("#submittername").text("Account Number must be 10 Digits only");
    else {
	 var accountNumber = document.getElementById('accountNumber');
	 var accountName1 = avs(bankCode, accountNumber.value);
	 }
    });
	   function avs(bankCode, accountNumber)
	   {		
			var accountName = "";
			var responseCode;
			var url = 'api.php?bankCode=' + bankCode + '&accountNumber=' + accountNumber;
			$.ajax({		
			type : 'GET',
			url  : url,
			dataType: 'json',
			success :  function(response)
			   {
				accountName = response.name;
				responseCode = response.responseCode;
				if(responseCode=='00'){
					$("#submittername").text(accountName);
					$("#submit").attr("disabled",false);
				}
				else {
					$("#submit").attr("disabled",true);
					$("#submittername").text("Invalid Account Number");
				}
				
			  }
			});
		}
});