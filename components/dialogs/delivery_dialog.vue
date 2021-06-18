<template>
    <v-dialog v-model="requisites_model"
              max-width="810" scrollable>
        <v-card>
            <v-card-title>
                <span class="headline">{{ delivery_dialog.data.title }}</span>
            </v-card-title>
            <v-card-text>
                <p v-html="delivery_dialog.data.text"></p>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <a @click="close_dialog" class="red-outline-btn">Закрыть</a>
            </v-card-actions>
        </v-card>
    </v-dialog>

</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex';

export default {
  name    : 'ModalDelivery',
  computed: {
    ...mapState('helpDialogs',
      [
        'delivery_dialog'
      ]
    ),
    requisites_model: {
      get() {
        return this.delivery_dialog.visible;
      },
      set(value) {
        this.UPDATE_DELIVERY_DIALOG_STATE({ key : 'visible', value });
      }
    }
  },
  methods: {
    ...mapMutations('helpDialogs',
      [
        'UPDATE_DELIVERY_DIALOG_STATE'
      ]
    ),
    ...mapActions('helpDialogs',['get_help_dialogs']),
    close_dialog() {
      this.UPDATE_DELIVERY_DIALOG_STATE({ key : 'visible', value : false });
    }
  }
};
</script>