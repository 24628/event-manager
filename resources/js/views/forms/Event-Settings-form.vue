<template>
    <div class="full-page-form">
        <div class="form-holder">
            <form
                class="form"
                method="post"
                @submit.prevent="checkForm"
            >
                <div v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li
                            v-for="error in errors"
                            :key="error"
                        >
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <h2 class="form-title">
                    Event Settings
                </h2>
                <div class="form-line">
                    <label
                        class="form-label"
                        for="visible_registrations"
                    >Visible registrations</label>
                    <input
                        id="visible_registrations"
                        v-model="visible_registrations"
                        class="form-text-input"
                        type="number"
                        name="visible_registrations"
                        placeholder="Visible registration"
                    >
                </div>
                <div class="form-line">
                    <label
                        class="form-label"
                        for="max_registrations"
                    >Max registrations</label>
                    <input
                        id="max_registrations"
                        v-model="max_registrations"
                        class="form-text-input"
                        type="number"
                        name="max_registrations"
                        placeholder="Max registration"
                    >
                </div>
                <div class="form-line">
                    <label
                        class="form-label"
                        for="primary_color"
                    >Primary color</label>
                    <input
                        id="primary_color"
                        v-model="primary_color"
                        class="form-text-input"
                        type="color"
                        name="primary_color"
                    >
                </div>
                <div class="form-line">
                    <label
                        class="form-label"
                        for="secondary_color"
                    >Secondary color</label>
                    <input
                        id="secondary_color"
                        v-model="secondary_color"
                        class="form-text-input"
                        type="color"
                        name="secondary_color"
                    >
                </div>
                <div class="form-line">
                    <label
                        class="form-label"
                        for="active"
                    >Active</label>
                    <input
                        id="active"
                        v-model="active"
                        class="form-text-input"
                        type="checkbox"
                        name="active"
                    >
                </div>
                <div class="form-line">
                    <input
                        type="submit"
                        value="Submit"
                        class="submit-btn"
                    >
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import API from '@/js/Api';

export default {
    data () {
        return {
            errors: [],
            event_id: this.$route.params.event_id,
            visible_registrations: null,
            max_registrations: null,
            primary_color: '',
            secondary_color: '',
            active: false
        };
    },
    methods: {
        checkForm: function (e) {
            this.errors = [];

            const data = {
                event_id: this.event_id,
                visible_registrations: this.visible_registrations,
                max_registrations: this.max_registrations,
                primary_color: this.primary_color,
                secondary_color: this.secondary_color,
                active: this.active
            };

            API.post(data, '/api/event-settings');

            e.preventDefault();
        }
    }
};
</script>
