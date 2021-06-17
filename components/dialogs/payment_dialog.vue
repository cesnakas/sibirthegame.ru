<template>
    <v-dialog v-model="payment_model"
              max-width="810" scrollable>
        <v-card>
            <v-card-title>
                <span class="headline">{{ payment_dialog.data.title }}</span>
            </v-card-title>
            <v-card-text>
                <p v-html="payment_dialog.data.text_befote"></p>
                <div>
                    <svg-icon v-for="(item, index) in payment_dialog.data.icons" :key="index" :name="item" 
                              class="card-icon" />
                </div>
                <p v-html="payment_dialog.data.text_after"></p>
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
  name    : 'ModalDelivery',
  computed: {
    ...mapState('helpDialogs',
      [
        'payment_dialog'
      ]
    ),
    payment_model: {
      get() {
        return this.payment_dialog.visible;
      },
      set(value) {
        this.UPDATE_PAYMENT_DIALOG_STATE({ key : 'visible', value });
      }
    }
  },
  methods: {
    ...mapMutations('helpDialogs',
      [
        'UPDATE_PAYMENT_DIALOG_STATE'
      ]
    ),
    close_dialog() {
      this.UPDATE_PAYMENT_DIALOG_STATE({ key : 'visible', value : false });
    }
  }
};
</script>
<style scoped>
.card-icon {
    width: 100px;
    height: 60px;
}
</style>