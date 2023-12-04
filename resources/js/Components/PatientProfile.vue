<script>
import { usePage } from '@inertiajs/vue3'

export default {
  props: {
    userId: {
      type: Number,
      required: true
    }
  },
  setup(props) {
    const { data: patient, error, status } = usePage().props

    return { patient, error, status }
  },
  mounted() {
    this.$inertia.get(`/patients/${this.userId}`)
  }
}
</script>