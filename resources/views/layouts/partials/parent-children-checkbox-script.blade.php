@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('parentChildrenCheckboxData', () => ({
                allChecked: false,
                onCheckboxItemChange() {
                    let checked = false;
                    let unchecked = false;
                    const checkboxes = this.$refs.checkboxItemContainer.querySelectorAll('input[type=checkbox]');
                    for (let i = 0; i < checkboxes.length; i++) {
                        const checkbox = checkboxes[i]
                        if (checkbox.checked) {
                            checked = true
                        } else {
                            unchecked = true
                        }

                        if (checked && unchecked) {
                            break
                        }
                    }

                    this.$refs.parentCheckbox.indeterminate = checked && unchecked;
                    this.allChecked = checked && !unchecked
                },
                onAllCheckedChange(event) {
                    const checkboxes = this.$refs.checkboxItemContainer.querySelectorAll('input[type=checkbox]');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = event.target.checked
                    })
                },
                init(){
                    this.onCheckboxItemChange()
                }
            }))
        })
    </script>
@endpush
