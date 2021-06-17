<template>
    <v-text-field
        v-bind="$attrs"
        v-on="$listeners"
        class="sb-text-field"
        filled
    />
</template>

<script>
export default {
  name: 'sb_text_field'
};
</script>

<style lang="scss" scoped>
.sb-text-field {
  &::v-deep .v-input__slot {
    border-radius: 0;
    overflow: hidden;
    height: 48px;

    input {
      font-size: 16px;
      color: #4F4F4F;
    }
  }
  &::v-deep .v-label {
    font-size: 14px;
  }
}
</style>
