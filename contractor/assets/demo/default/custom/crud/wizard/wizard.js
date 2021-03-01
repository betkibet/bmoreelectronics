var WizardDemo = function () {
  $('#m_wizard');
  var e,
  r,
  i = $('#m_form');
  return {
    init: function () {
      var n;
      $('#m_wizard'),
      i = $('#m_form'),
      (r = new mWizard('m_wizard', {
        startStep: 1
      })).on('beforeNext', function (r) {
        !0 !== e.form() && r.stop()
      }),
      r.on('change', function (e) {
        mUtil.scrollTop()
      }),
      e = i.validate({}),
      (n = i.find('[data-wizard-action="submit"]')).on('click', function (r) {
        //r.preventDefault(),
        e.form() && (mApp.progress(n), i.ajaxSubmit({
          success: function () {
			  $('.chk_device_frm').submit();
            /*mApp.unprogress(n),
            swal({
              title: '',
              text: 'The application has been successfully submitted!',
              type: 'success',
              confirmButtonClass: 'btn btn-secondary m-btn m-btn--wide'
            })*/
          }
        }))
      })
    }
  }
}();
jQuery(document).ready(function () {
  WizardDemo.init()
});
