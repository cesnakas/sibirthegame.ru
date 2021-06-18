<template>
    <v-dialog v-model="requisites_model"
              max-width="810" scrollable>
        <v-card>
            <v-card-title>
                <span class="headline">{{requisites_dialog.data.title}}</span>
            </v-card-title>
            <v-card-text>
                <v-simple-table>
                    <template v-slot:default>
                        <tbody>
                            <tr v-for="(item, index) in requisites_dialog.data.items" :key="index">
                                <td>{{ item.label }}</td>
                                <td>{{ item.text }}</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
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
  name    : 'ModalRequisites',
  computed: {
    ...mapState('helpDialogs',
      [
        'requisites_dialog'
      ]
    ),
    requisites_model: {
      get() {
        return this.requisites_dialog.visible;
      },
      set(value) {
        this.UPDATE_REQUISITES_DIALOG_STATE({ key : 'visible', value });
      }
    }
  },
  methods: {
    ...mapMutations('helpDialogs',
      [
        'UPDATE_REQUISITES_DIALOG_STATE'
      ]
    ),
    close_dialog() {
      this.UPDATE_REQUISITES_DIALOG_STATE({ key : 'visible', value : false });
    }
  }
};
</script>