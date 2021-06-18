export default Object.freeze({
  MASKS: {
    phone     : '+7 (9##) ###-##-##',
    homePhones: '+7 ##########'
  },
  RULES: {
    name       : [v => (!!v && v.length >= 2) || 'Поле обязательно для заполнения'],
    phone      : [v => (!!v && v.length === 15) || 'Номер должен состоять из 10 цифр'],
    maskedPhone: [v => (!!v && v.length === 18) || 'Номер должен состоять из 10 цифр'],
    email      : [v => /.+@.+\..+/.test(v) || 'Введите корректный email'],
    required   : [value => !!value || 'Поле обязательно для заполнения']
  }
});
