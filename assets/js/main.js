$(document).ready(function(){
    $('#income-form').submit(function(e) {
        if(!validateInput('income')) {
            e.preventDefault();
        }
    });

    $('#expense-form').submit(function(e) {
        if(!validateInput('expense')) {
            e.preventDefault();
        }
    });

    $('.delete-btn').on("click", function(e){
        value = confirm("Are you sure?");
        if(value <= 0){
            e.preventDefault();
        }
    });

    function validateInput(type){
        var amount = $('#' + type + '-amount').val();
        var desc = $('#' + type + '-desc').val();
        
        if(amount.trim() === ''){
            alert("Amount Empty!");
            return false;
        }
        
        var inputCheck = /^-?\d*\.?\d+$/;
        if(!inputCheck.test(amount)){
            alert("Invalid Input!");
            return false;
        }

        //Sanitize
        amount = DOMPurify.sanitize(amount);
        desc = DOMPurify.sanitize(desc);
        return true;
    }
});
