@props([
    'alwaysOpen' => false, // Jika true, multiple item bisa terbuka bersamaan
    'variant' => 'default',
    'gap' => 'space-y-4', // Gap antara item accordion
])

<div x-data="accordion{{ uniqid() }}()" class="{{ $gap }}" {{ $attributes }}>
    {{ $slot }}
</div>

<script>
    function accordion{{ uniqid() }}() {
        return {
            alwaysOpen: {{ $alwaysOpen ? 'true' : 'false' }},
            openItems: [],

            init() {
                // Initialize open items based on data
                this.$el.querySelectorAll('[x-data]').forEach((item, index) => {
                    if (item.__x.getUnobservedData().isOpen) {
                        this.openItems.push(index);
                    }
                });
            },

            toggleItem(index) {
                if (this.alwaysOpen) {
                    const itemIndex = this.openItems.indexOf(index);
                    if (itemIndex > -1) {
                        this.openItems.splice(itemIndex, 1);
                    } else {
                        this.openItems.push(index);
                    }
                } else {
                    this.openItems = this.openItems[0] === index ? [] : [index];
                }
            },

            isOpen(index) {
                return this.openItems.includes(index);
            }
        }
    }
</script>
