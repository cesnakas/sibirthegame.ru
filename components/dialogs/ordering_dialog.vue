<template>
    <no-ssr>
        <v-dialog v-model="ordering_dialog_model"
                  max-width="810">
            <v-card class="v-application v-application--is-ltr theme--light">
                <v-container>
                    <v-form ref="form"
                            lazy-validation
                            class="ordering-form">
                        <v-btn
                            @click="ordering_dialog_model = false"
                            class="ordering-from__close"
                            icon
                            dark
                        >
                            <svg-icon name="close__icon" class="ordering-from__close--svg" />
                        </v-btn>
                        <div class="ordering-left">
                            <h3 class="ordering__title">Оформление заказа</h3>

                            <SbTextField
                                v-model="name_model"
                                :rules="rules.name"
                                label="Ваше имя*"
                            />
                            <SbTextField
                                v-model="email_model"
                                :rules="rules.email"
                                label="E-mail*"
                            />
                            <div class="VuePhoneNumberInput">
                                <VuePhoneNumberInput v-model="phone_model" :translations='info' @update="updatePhone" 
                                                     no-example/>
                            </div>
                            <!-- <SbTextField
                                v-model="phone_model"
                                v-mask="masks.phone"
                                :rules="rules.maskedPhone"
                                label="Телефон*"
                            /> -->
                            <!-- <span class="ordering-form__label">Способ доставки</span> -->
                            <div class="ordering-delivery">
                                <div :class="{ 'active': delivery_method_model === 'courier' }"
                                     @click="change_delivery_method('courier')"
                                     class="ordering-delivery-item">
                                    <svg-icon name="truck" class="ordering-delivery-item__img" />
                                    <span class="ordering-delivery-item__text">Доставка курьером</span>
                                </div>
                                <div :class="{ 'active': delivery_method_model === 'rus_post_land' }"
                                     @click="change_delivery_method('rus_post_land')"
                                     class="ordering-delivery-item">
                                    <svg-icon name="box" class="ordering-delivery-item__img" />
                                    <span class="ordering-delivery-item__text">Почта России</span>
                                </div>
                                <div :class="{ 'active': delivery_method_model === 'pick-up' }"
                                     @click="change_delivery_method('pick-up')"
                                     class="ordering-delivery-item">
                                    <img src="/img/pickup-point.png">
                                    <span class="ordering-delivery-item__text">Самовывоз</span>
                                </div>
                            </div>
                            <div v-if="delivery_method_model === 'courier'">
                                <SbDadataAdress
                                    :rules="rules.required"
                                    v-model="full_address_model"
                                    label="Адрес доставки*"/>
                                <div class="ordering__fields">
                                    <SbTextField
                                        v-model="apartment"
                                        :rules="rules.required"
                                        label="Квартира/офис*"
                                    />
                                    <SbTextField
                                        v-model="postcode"
                                        @blur="chachePostCode($event)"
                                        :rules="rules.required"
                                        label="Индекс*"
                                    />
                                </div>            
                                <div class="ordering__fields ordering__fields--small">
                                    <SbTextField
                                        v-model="entrance"
                                        label="Подъезд"
                                    />

                                    <SbTextField
                                        v-model="floor"
                                        label="Этаж"
                                    />

                                    <SbTextField
                                        v-model="intercom"
                                        label="Домофон"
                                    />
                                </div>
                            </div> 
                            <div v-else-if="delivery_method_model === 'rus_post_land'">
                                <v-radio-group v-model="radioGroup">
                                    <v-radio label="Доставка по РФ" color="red" value="rus_post_land" />
                                    <v-radio label="Международная доставка" color="red" value="post_world" />
                                </v-radio-group>
                                <div v-if='radioGroup === "rus_post_land"'>
                                    <SbDadataAdress
                                        :rules="rules.required"
                                        v-model="full_address_model"
                                        label="Адрес доставки*"/>
                                    <div class="ordering__fields">
                                        <SbTextField
                                            v-model="apartment"
                                            :rules="rules.required"
                                            label="Квартира/офис*"
                                        />
                                        <SbTextField
                                            v-model="postcode"
                                            @blur="chachePostCode($event)"
                                            :rules="rules.required"
                                            label="Индекс*"
                                        />
                                    </div>  
                                </div>
                                <div v-else>
                                    <SbTextField
                                        v-model="country"
                                        label="Страна"
                                    />
                                    <SbTextField
                                        :rules="rules.required"
                                        v-model="full_address_model"
                                        label="Адрес*"
                                    />
                                </div>          
                            </div>
                            <div v-else>
                                {{pickUpText}}
                            </div>
                            <p v-if="delivery_cost_err" class="ordering-cost__desc">Что-то пошло не так. Невозможно рассчитать стоимость доставки. Пожалуйста, введите адрес заново.</p>
                            <SbCheckbox
                                :value="ordering_dialog.data.agreement"
                                @change="updateCheckbox"
                                required
                                label="Согласен на обработку персональных данных"
                            />
                        </div>
                        <div class="ordering-right">
                            <div class="ordering-cover">
                                <img class="ordering-cover__img" src="img/game_box.png" alt="Коробка с игрой">
                                <p class="ordering-cover__descr">Настольная игра<br>
                                <b>«Сибирь. Начало»</b></p>
                            </div>
                            <div class="ordering-cost">
                                <div class="ordering-cost__item">
                                    <p class="ordering-cost__item__text">Количество</p>
                                    <div class="ordering-cost__quantity">
                                        <button @click="delete_position_click" class="ordering-cost__quantity__btn" type="button">-</button>
                                        <p class="ordering-cost__item__text ordering-cost__item__text--big">{{ quantity_model }}</p>
                                        <button @click="add_position_click" class="ordering-cost__quantity__btn" type="button">
                                            +
                                        </button>
                                    </div>
                                </div>
                                <div class="ordering-cost__item">
                                    <p class="ordering-cost__item__text">Стоимость</p>
                                    <p class="ordering-cost__item__text">{{ cost_model }} ₽</p>
                                </div>
                                <div v-if="cost_of_delivery_model && cost_of_delivery_model !== 0" class="ordering-cost__item">
                                    <p class="ordering-cost__item__text">Доставка</p>
                                    <p class="ordering-cost__item__text">{{ cost_of_delivery_model }} ₽</p>
                                </div>
                                <div class="ordering-cost__item">
                                    <p class="ordering-cost__item__text">К оплате</p>
                                    <b class="ordering-cost__item__text ordering-cost__item__text--big">{{ toPay_model }} ₽</b>
                                </div>
                                <p class="ordering-cost__desc">{{ order_text }}</p>
                                <v-btn
                                    @click="pay_click()"
                                    :disabled="!ordering_dialog.data.agreement || disabled_pay_btn"
                                    rounded
                                    class="red-btn"
                                >Оплатить</v-btn>
                            </div>
                        </div>
                    </v-form>

                    <div id="hidden__forms" class="hidden">
                      
                    </div>
                </v-container>
            </v-card>
        </v-dialog>
    </no-ssr>

</template>

<script>
import { mapMutations, mapState, mapActions }             from 'vuex';
import constants                                          from '@/constants';
import VuePhoneNumberInput                                from 'vue-phone-number-input';

export default {
  name      : 'ModalOrdering',
  components: {
    VuePhoneNumberInput
  },
  data() {
    return {
      info: {
        countrySelectorLabel: 'Код страны',
        countrySelectorError: 'Выберите страну',
        phoneNumberLabel    : 'Телефон'
      },
      phoneValid: false
      // radioGroup: 'rus_post_land'
    };
  },
  computed: {
    ...mapState('orderingDialog',
      [
        'ordering_dialog'
      ]
    ),
    ...mapState('global',
      [
        'order_text',
        'pickUpText'
      ]
    ),
    masks() {
      return constants.MASKS;
    },
    rules() {
      return constants.RULES;
    },

    ordering_dialog_model: {
      get() {
        return this.ordering_dialog.visible;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_STATE({ key : 'visible', value });
      }
    },
    name_model: {
      get() {
        return this.ordering_dialog.data.name;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'name', value });
      }
    },
    city: {
      get() {
        return this.ordering_dialog.data.city;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'city', value });
      }
    },
    radioGroup: {
      get() {
        return this.ordering_dialog.data.radioGroup;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'full_address', value : '' });
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'radioGroup', value });
      }
    },
    country: {
      get() {
        return this.ordering_dialog.data.country;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'country', value });
      }
    },
    email_model: {
      get() {
        return this.ordering_dialog.data.email;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'email', value });
      }
    },
    phone_model: {
      get() {
        return this.ordering_dialog.data.phone;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'phone', value });
      }
    },
    delivery_method_model: {
      get() {
        return this.ordering_dialog.data.delivery_method;
      },
    },
    full_address_model: {
      get() {
        return this.ordering_dialog.data.full_address;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'full_address', value });
      }
    },
    apartment: {
      get() {
        return this.ordering_dialog.data.apartment;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'apartment', value });
      }
    },
    postcode: {
      get() {
        return this.ordering_dialog.data.postcode;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'postcode', value });
      }
    },
    entrance: {
      get() {
        return this.ordering_dialog.data.entrance;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'entrance', value });
      }
    },
    floor: {
      get() {
        return this.ordering_dialog.data.floor;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'floor', value });
      }
    },
    intercom: {
      get() {
        return this.ordering_dialog.data.intercom;
      },
      set(value) {
        this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'intercom', value });
      }
    },
    formLink: {
      get() {
        return this.ordering_dialog.data.formLink;
      },
    },
    cost_model: {
      get() {
        return this.ordering_dialog.data.cost;
      }
    },
    quantity_model: {
      get() {
        return this.ordering_dialog.data.quantity;
      }
    },
    cost_of_delivery_model: {
      get() {
        return this.ordering_dialog.data.cost_of_delivery;
      }
    },
    toPay_model: {
      get() {
        return this.ordering_dialog.data.toPay;
      }
    },
    delivery_cost_err: {
      get() {
        return this.ordering_dialog.data.full_address && this.delivery_method_model !== 'pick-up' && (!this.cost_of_delivery_model || this.cost_of_delivery_model === 0);
      }
    },
    disabled_pay_btn: {
      get() {
        if (this.delivery_method_model !== 'pick-up') {
          return !this.ordering_dialog.data.name || !this.ordering_dialog.data.email || !this.phoneValid || !this.ordering_dialog.data.full_address || !this.ordering_dialog.data.postcode || this.delivery_cost_err;
        } else {
          return !this.ordering_dialog.data.name || !this.ordering_dialog.data.email || !this.phoneValid;
        }
      }
    },
    getFormSelector() {
      return document.querySelector('#hidden__forms form');
    },
  },
  watch: {
    formLink(newValue, oldValue) {
      if(newValue !== oldValue) {
        window.location.href = newValue;
      }
    }
  },
  methods: {
    ...mapMutations('orderingDialog',
      [
        'UPDATE_ORDERING_DIALOG_STATE',
        'UPDATE_ORDERING_DIALOG_DATA_STATE'
      ]
    ),
    ...mapActions('orderingDialog',
      [
        'send_order',
        'send_delivery'
      ]
    ),
    async change_delivery_method(method) {
      this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'full_address', value : '' });
      this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'delivery_method', value : method });
      await this.send_delivery();
    },
    async add_position_click() {
      const new_quantity = this.ordering_dialog.data.quantity + 1;
      this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'quantity', value : new_quantity });
      await this.send_delivery();
    },
    async delete_position_click() {
      let new_quantity = this.ordering_dialog.data.quantity;
      if (new_quantity > 1) {
        new_quantity = new_quantity - 1;
      }
      this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'quantity', value : new_quantity });
      await this.send_delivery();
    },
    async chachePostCode() {
      await this.send_delivery();
    },
    async pay_click() {
      if (this.$refs.form.validate()) {
        await this.send_order();
      }
    },
    updateCheckbox(val) {
      const value = !!val;
      this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'agreement', value });
    },
    updatePhone(payload) {
      this.phoneValid = payload.isValid;
    }
  }
};
</script>

<style lang="scss" scoped>

.v-dialog {
    border-radius: 0!important;
    box-shadow: 0px 24px 38px rgba(0, 0, 0, 0.14), 0px 9px 46px rgba(0, 0, 0, 0.12), 0px 11px 15px rgba(0, 0, 0, 0.2)!important;
    .v-card {
        border-radius: 0;
        box-shadow: none;
    }
}
.v-input--selection-controls {
  margin-top: 0;
}
.red-btn {
    width: 100%;
    color: #fff;
    background: #b54c3e !important;
    font-size: 17px !important;
    text-transform: none;
    letter-spacing: normal;
}
.ordering-from__close {
    position: absolute;
    width: 20px;
    height: 20px;
    right: 20px;
    top: 20px;
}
.ordering-from__close--svg {
    width: 100%;
    height: 100%;
    max-height: 20px;
}
.hidden {
    // position: absolute;
    // left: -1000px;
    // top: -1000px;
    visibility: hidden;
    // display: none;
}

@media (max-width: 740px) {
    .v-dialog {
        overflow-y: scroll!important;
    }
}
</style>
