<template>
  <v-btn
    class="e-colorswatch"
    fab
    elevation="0"
    width="30"
    height="30"
    :color="color"
    @click="picker.onInput(color)"
  ></v-btn>
</template>
<script>
import { contrastColor } from '@/common/helpers/colors.js'

export default {
  name: 'ColorSwatch',
  props: {
    picker: { type: Object, required: true },
    color: { type: String, required: true },
  },
  computed: {
    contrast() {
      return this.color ? contrastColor(this.color) : 'black'
    },
  },
}
</script>
<style scoped>
.e-colorswatch::after {
  content: '•';
  color: v-bind(contrast);
  display: block;
  width: 100%;
  height: 100%;
  line-height: 26px;
  font-size: 28px;
  text-align: center;
}
</style>
