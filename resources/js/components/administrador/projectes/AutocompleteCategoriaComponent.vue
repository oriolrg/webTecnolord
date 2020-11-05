<template>
  <div>
    <b-form-group :state="state" label="Categories" label-for="tags-validation">
      <b-form-tags
        input-id="tags-validation"
        :input-attrs="{ 'aria-describedby': 'tags-validation-help' }"
        v-model="tags"
        :state="state"
        :tag-validator="tagValidator"
        separator=" "
		    :value="this.tags"
      ></b-form-tags>
      <!-- The following slots are for b-form-group -->
      <template #invalid-feedback>
        Hi ha algun error
      </template>
      <template #description>
        <div id="tags-validation-help">
         Tags d'entre 3 i 5 caracters
        </div>
      </template>
    </b-form-group>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        tags: [],
        dirty: false
      }
    },
    computed: {
      state() {
        // Overall component validation state
        this.$emit('tags', this.tags);
        return this.dirty ? (this.tags.length > 3 && this.tags.length < 10) : null
      }
    },
    watch: {
      tags(newVal, oldVal) {
        // Set the dirty flag on first change to the tags array
        this.dirty = true
      }
    },
    methods: {
      tagValidator(tag) {
        // Individual tag validator function
        return tag === tag.toLowerCase() && tag.length > 2 && tag.length < 7
      }
    }
  }
</script>