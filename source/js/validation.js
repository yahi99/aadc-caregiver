jQuery.validator.addMethod("zipcode", function(value, element) {
  return this.optional(element) || /^\d{5}(?:-\d{4})?$/.test(value);
}, "Please provide a valid zipcode.");

$("#frmSS149").validate({
    rules: {
      'CustomFields[2]': {
        required: true,
      },

      'CustomFields[3]': {
        required: true,
      },

      'CustomFields[751]': {
        required: true,
      },

      'CustomFields[10]': {
        required: true,
        zipcode: true,
      }
      
    },
    messages: {
      'CustomFields[2]': "First name is required.",
      'CustomFields[3]': "Last name is required.",
      'CustomFields[751]': "Please select a state.",
      email: {
      	required: "Email address is required.",
      },
      'CustomFields[10]': {
        required: "ZIP code is required.",
        digits: "Must only contain numbers.",
      }
    },
    
    errorPlacement: function(error, element) {
          if(element.is(":radio")) {
            error.insertBefore(element.parent('.custom-radio').parents('.radio'));    
          } else
          if(element.is(":checkbox")) {
            error.insertBefore(element.parent('.custom-checkbox').parents('.form-group'));    
          } else {
            error.insertAfter(element);
          }   
    },

    errorElement: "span",

    submitHandler: function(form) {

      // Fade in spinner icon while form is being submitted
      $('#loader').fadeIn().css("display", "inline-block");
      
      form.submit();
    },

    invalidHandler: function() {

      // Hide spinner icon if form fails to submit
      $('#loader').fadeOut();
    }
 });

// Show if checked  
$('.yes').change(function(){
    $('#hidden').removeClass(' hidden');
});

$('.no').change(function(){
    $('#hidden').addClass(' hidden');
});

$('#frmSS149 select').change(function() { $(this).valid()});




