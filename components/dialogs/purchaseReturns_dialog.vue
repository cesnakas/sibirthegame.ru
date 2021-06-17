<template>
    <v-dialog v-model="purchaseReturns_model"
              max-width="810" scrollable>
        <v-card>
            <v-card-title>
                <span class="headline">{{ purchaseReturns_dialog.data.title }}</span>
            </v-card-title>
            <v-card-text>
                <p v-html="purchaseReturns_dialog.data.text"></p>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <a @click="close_dialog" class="red-outline-btn">Закрыть</a>
            </v-card-actions>
        </v-card>
    </v-dialog>

</template>

<script>
import { mapMutations, mapState } from 'vuex';

export default {
  name    : 'ModalPurchaseReturns',
  computed: {
    ...mapState('helpDialogs',
      [
        'purchaseReturns_dialog'
      ]
    ),
    purchaseReturns_model: {
      get() {
        return this.purchaseReturns_dialog.visible;
      },
      set(value) {
        this.UPDATE_PURCHASERETURNS_DIALOG_STATE({ key : 'visible', value });
      }
    }
  },
  methods: {
    ...mapMutations('helpDialogs',
      [
        'UPDATE_PURCHASERETURNS_DIALOG_STATE'
      ]
    ),
    close_dialog() {
      this.UPDATE_PURCHASERETURNS_DIALOG_STATE({ key : 'visible', value : false });
    }
  }
};
</script>