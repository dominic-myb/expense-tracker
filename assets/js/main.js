$(document).ready(function(){
    $('#record-form').submit(function(e) {
        if(!validateInput('record')) {
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

    $('#update-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes

        // AJAX call to fetch data from the server
        $.ajax({
            url: 'update.php', // Path to your server-side script to fetch record
            method: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                // Populate modal fields with fetched data
                $('#update-id').val(id);
                $('#dropdown').val(response.type);
                $('#update-amount').val(response.amount);
                $('#update-desc').val(response.description);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching record:', error);
            }
        });
    });
});
