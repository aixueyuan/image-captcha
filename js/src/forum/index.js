import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import SignUpModal from 'flarum/forum/components/SignUpModal';

app.initializers.add('aixueyuan-image-captcha', () => {
  extend(SignUpModal.prototype, 'oninit', function() {
    this.captchaImage = m.prop('');
    this.captchaCode = m.prop('');
    this.loadCaptcha();
  });

  SignUpModal.prototype.loadCaptcha = function() {
    app.request({
      method: 'GET',
      url: app.forum.attribute('apiUrl') + '/captcha/generate'
    }).then(result => {
      this.captchaImage(result.image);
    });
  };

 
  extend(SignUpModal.prototype, 'fields', function(items) {
      // 只在启用时显示验证码
      if (app.forum.attribute('imageCaptchaEnabled')) {
          items.add('captcha',
              m('.Form-group', [
                  m('label', app.translator.trans('aixueyuan-image-captcha.forum.signup.captcha_label')),
                  m('img', {
                      src: this.captchaImage(),
                      onclick: () => this.loadCaptcha()
                  }),
                  m('input.FormControl', {
                      name: 'captchaCode',
                      type: 'text',
                      placeholder: app.translator.trans('aixueyuan-image-captcha.forum.signup.captcha_placeholder'),
                      value: this.captchaCode(),
                      onchange: m.withAttr('value', this.captchaCode)
                  })
              ])
          );
      }
  });


  extend(SignUpModal.prototype, 'submitData', function(data) {
    data.captchaCode = this.captchaCode();
  });
});