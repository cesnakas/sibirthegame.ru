<template>
    <v-checkbox
        v-bind="$attrs"
        v-on="$listeners"
        color="#B54C3E"
        hide-details
        class="sb-checkbox"
    />
</template>

<script>
export default {
  name: 'sb_checkbox'
};
</script>

<style lang="scss" scoped>
.sb-checkbox {
  &::v-deep .v-label {
    font-size: 12px;
  }
}
</style>