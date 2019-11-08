<form id="sunsetContactForm" class="sunset-contact-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>" xmlns="http://www.w3.org/1999/html">
    <div class="form-group">
        <input type="text" class="form-control sunset-form-control" placeholder="Your Name" id="name" name="name" ">
        <small class="text-danger form-control-msg">Your name is Required</small>
    </div>
    <div class="form-group">
        <input type="text" class="form-control sunset-form-control" placeholder="Your Email" id="email" name="email" ">
        <small class="text-danger form-control-msg">Your email is Required</small>
    </div>
    <div class="form-group">
        <textarea class="form-control sunset-form-control" id="message" name="message" "></textarea>
        <small class="text-danger form-control-msg">A message is Required</small>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-default btn-lg btn-sunset-form">Submit</button>
        <small class="text-info form-control-msg js-form-submission">Submission in process, please wait...</small>
        <small class="text-success form-control-msg js-form-success">Message successfully submitted, thank you!</small>
        <small class="text-danger form-control-msg js-form-error">There was a problem with the Contact Form, please try again!</small>
    </div>
</form>