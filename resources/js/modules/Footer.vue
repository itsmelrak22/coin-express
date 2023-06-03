<template>
  <v-footer
    app
    fixed
    tile
    dense
    inset
  >
    <span class="caption pt-0">
        Rows: {{ items }}
    </span>
  </v-footer>
</template>
<script>
export default {
  props: {
    "items": {
      type: Number 
    }
  }
}
</script>