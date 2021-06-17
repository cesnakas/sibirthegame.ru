import axios from 'axios';

let base_url = '';
if(process.env.NODE_ENV === 'development') {
  base_url = 'https://dev01.sibirthegame.dev.defa.ru';
}else {
  base_url = '';
}

/**
 * Получение стоимости доставки
 * @param params
 * @returns {Promise<Response<any>>}
 */
const get_delivery = (params) => {
  return axios.post(`${base_url}/api/order/delivery/get-list/`, params);
  // return axios.post('/api/order/delivery/get-list/', params);
};

/**
 * Отправить заказ
 * @param params
 * @returns {Promise<Response<any>>}
 */
const get_order = (params) => {
  return axios.post(`${base_url}/api/order/make/`, params);
};
/**
 * Глобальные данные по сайту
 * @param params
 * @returns {Promise<Response<any>>}
 */
const get_global = () => {
  return axios.get(`${base_url}/api/global/`);
};
/**
 * Получаем данные для блока "Что в коробке"
 * @param params
 * @returns {Promise<Response<any>>}
 */
const get_inBox = () => {
  return axios.get(`${base_url}/api/content/in-box/`);
};
/**
 * Получаем данные для словника
 * @param params
 * @returns {Promise<Response<any>>}
 */
const get_slovnik = () => {
  return axios.get(`${base_url}/api/content/slovnik/`);
};
/**
 * Получаем данные для ограничений
 * @param params
 * @returns {Promise<Response<any>>}
 */
const get_limitations = () => {
  return axios.get(`${base_url}/api/content/limitations/`);
};
/**
 * Получаем данные для блока Механика игры
 * @param params
 * @returns {Promise<Response<any>>}
 */
const get_mechanics = () => {
  return axios.get(`${base_url}/api/content/mechanics/`);
};
/**
 * Получаем данные для блока Об издателе
 * @param params
 * @returns {Promise<Response<any>>}
 */
const get_publisher = () => {
  return axios.get(`${base_url}/api/content/publisher/`);
};
/**
 * Получаем данные для help-модалок
 * @param params
 * @returns {Promise<Response<any>>}
 */
const get_helpDialogs = () => {
  return axios.get(`${base_url}/api/content/help/`);
};

export {
  get_delivery,
  get_order,
  get_global,
  get_inBox,
  get_slovnik,
  get_limitations,
  get_mechanics,
  get_helpDialogs,
  get_publisher
};