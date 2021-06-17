<template>
    <v-autocomplete
        v-if="!disabled"
        v-bind="$attrs"
        @input="inputHandler"
        :items="items"
        :loading="isLoading"
        :search-input.sync="search"
        :filter="() => true"
        :label="label"
        v-model="model"
        @change="changed"
        auto-select-first
        item-text="value"
        item-value="data"
        return-object
        class="dadata-field"
        clearable
    />
    <!-- <RnTextField
        v-else
        :label="label"
        :value="text_value"
        :field_edited="field_edited"
        disabled
    /> -->
</template>

<script>
import { mapMutations, mapState, mapActions } from 'vuex';
import _debounce                              from 'lodash.debounce';
import axios                                  from 'axios';
export default {
  name : 'sb_dadata_address',
  props: {
    disabled    : Boolean,
    label       : String,
    value       : [Object, String],
    field_edited: {
      type   : Boolean,
      default: false,
    },
    methodCourser: String
  },
  data: () => ({
    entries  : [],
    isLoading: false,
    model    : null,
    search   : null,
  }),
  computed: {
    ...mapState('orderingDialog',
      [
        'ordering_dialog'
      ]
    ),
    delivery_method_model: {
      get() {
        return this.ordering_dialog.data.delivery_method;
      },
    },
    token() {
      return '3f4a4d504a9c843c8a8f24136c8776b613a84865';
    },
    items() {
      return this.entries.map(x => ({
        value: x.value,
        data : {
          Index     : x.data.postal_code ? x.data.postal_code : '',
          Subject   : x.data.region ? x.data.region : '',
          City      : x.data.city || x.data.settlement_with_type || '',
          Street    : x.data.street ? x.data.street : '',
          HomeNumber: x.data.house ? x.data.house : '',
          FlatNumber: x.data.flat ? x.data.flat : '',
          KLADR     : x.data.kladr_id ? x.data.kladr_id : '',
        }
      }));
    },
    text_value() {
      if (this.value && this.value.value) {
        return this.value.value;
      }
      return this.value;
    },
  },
  watch: {
    search: _debounce(async function(val) {
      this.isLoading = true;
      try {
        if(this.delivery_method_model === 'courier') {
          const {data} = await axios.post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address', { query    : val , locations: [{
            region: 'москва'
          }]}, {
            headers: { 
              Authorization: `Token ${this.token}` 
            }
          });
          this.entries = data.suggestions;
        }else {
          const {data} = await axios.post('https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address', { query : val }, {
            headers: { 
              Authorization: `Token ${this.token}` 
            }
          });
          this.entries = data.suggestions;
        }
      } catch (e) {
        console.error('Dadata access error');
      } finally {
        this.isLoading = false;
      }
    }, 200),
    value(val) {
      if (!this.disabled && typeof val === 'string') {
        this.setInitialValue(val);
      }
    },
  },
  methods: {
    ...mapMutations('orderingDialog',
      [
        'UPDATE_ORDERING_DIALOG_DATA_STATE'
      ]
    ),
    ...mapActions('orderingDialog', 
      [
        'send_delivery'
      ]),
    inputHandler(input) {
      this.$emit('input', input);
    },
    async changed(value) {
      if (value) {
        const {Index, City} = value.data;
        this.$emit('change', value);
        if(Index !== '') {
          this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'postcode', value : Index });
        }
        if(City !== '') {
          this.UPDATE_ORDERING_DIALOG_DATA_STATE({ key : 'city', value : City });
        }
        await this.send_delivery();
      }
    },
  }
};
</script>

<style lang="scss" scoped>
.dadata-field {
    // overflow: hidden;
    padding-top: 0;

    &::v-deep .v-input__slot {
        border-radius: 0px;
        min-height: 56px;
        overflow: hidden;

        input {
            color: #000;
            font-size: 16px;
            padding-top: 0;
        }
    }

    &::v-deep .v-select__selections {
        flex-wrap: nowrap;
    }

    &::v-deep .v-input__control > .v-input__slot:before {
        display: none;
    }

    &::v-deep .v-input__control > .v-input__slot:after {
        border-bottom-width: 2px;
    }

    &::v-deep .v-input__control > .v-input__slot {
        padding: 0 16px !important;
        background-color: #f5f4f6;
    }

    &::v-deep .v-label {
        top: 6px;
    }

    &::v-deep .v-messages__wrapper {
        padding-left: 12px;
    }

    &.v-input--is-focused ,
    &.v-input--is-label-active {
        &::v-deep .v-label {
            top: 13px;
        }

        &::v-deep input {
            position: relative;
            top: 13px;
        }
    }

    &.v-input--is-disabled {
        &::v-deep .v-label--is-disabled {
            color: #b4b5b7;
        }

        &::v-deep input:disabled {
            color: #000;
        }

        &::v-deep .v-input__slot {
            background-color: transparent;

            &:before {
                border: none;
            }
        }

        &::v-deep .v-input__icon {
            display: none;
        }
    }
}

.v-menu__content {
    .v-select-list {
        background: #f2f2f2;
        width: 100%;
        &::v-deep .v-list-item__title {
            white-space: break-spaces!important;
        }
    }
}
</style>
