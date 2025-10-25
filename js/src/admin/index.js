import app from 'flarum/admin/app';

app.initializers.add('aixueyuan-image-captcha', () => {
  app.extensionData
    .for('aixueyuan-image-captcha')
    .registerSetting({
      setting: 'image-captcha.enabled',
      label: app.translator.trans('aixueyuan-image-captcha.admin.settings.enabled'),
      type: 'boolean'
    });
});