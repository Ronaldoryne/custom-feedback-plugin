jQuery(document).ready(function($){
    $('.cfp-feedback-form').on('submit', function(e){
        e.preventDefault();
        alert('Your feedback has been sent! (Processing to backend can be added here)');
    });
});
