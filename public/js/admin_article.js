console.log('ici');

$(function () {
    $('#article_category').change(function () {
        var $this = $(this);

        if ($this.val() == 2) {
            $('#expo').show();
            $('#presse').hide();
        } else if($this.val() == 3) {
            $('#presse').show();
            $('#expo').hide();
        } else {
            $('#presse').hide();
            $('#expo').hide();
        }
    });

})