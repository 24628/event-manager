<template>
    <div class="full-page-form">
        <div class="form-holder">
            <form
                class="form"
                autocomplete="off"
                @submit.prevent="requestRegister"
            >
                <h2 class="form-title">
                    Register Account
                </h2>

                <div
                    v-if="isLoading"
                    class="form-line form-loading"
                >
                    <loading />
                </div>

                <div
                    v-if="errors.length"
                    class="form-errors"
                >
                    <p>Fout:</p>
                    <ul>
                        <li
                            v-for="error in errors"
                            :key="error"
                        >
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <div
                    v-if="!!message"
                    class="form-message"
                >
                    {{ message }}
                </div>

                <div class="form-line">
                    <label
                        class="form-label"
                        for="name"
                    >Naam</label>
                    <input
                        id="name"
                        v-model="name"
                        class="form-text-input"
                        type="text"
                    >
                </div>
                <div class="form-line">
                    <label
                        class="form-label"
                        for="email"
                    >E-mail</label>
                    <input
                        id="email"
                        v-model="email"
                        class="form-text-input"
                        type="text"
                        required
                    >
                </div>
                <div class="form-line">
                    <label
                        class="form-label"
                        for="password"
                    >Wachtwoord</label>
                    <input
                        id="password"
                        v-model="password"
                        class="form-text-input"
                        type="password"
                    >
                </div>
                <div class="form-line">
                    <label
                        class="form-label"
                        for="password_confirmation"
                    >Bevestig Wachtwoord</label>
                    <input
                        id="password_confirmation"
                        v-model="password_confirmation"
                        class="form-text-input"
                        type="password"
                    >
                </div>
                <div class="form-line">
                    <label
                        class="form-label"
                        for="role"
                    >Soort Bezoeker</label>
                    <select
                        id="role"
                        v-model="role"
                        class="form-text-input"
                    >
                        <option
                            v-for="userrole in roles"
                            :key="userrole.id"
                            :value="userrole.id"
                        >
                            {{ userrole.role_name }}
                        </option>
                    </select>
                </div>
                <div class="form-line">
                    <input v-model="terms" type="checkbox">
                    <label class="form-label" for="terms">Algemene voorwaarden</label>
                </div>
                <div class="form-line form-line-hasbutton">
                    <input
                        type="submit"
                        class="form-button"
                        value="registreer account"
                    >
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import loading from '@/js/components/loading';

export default {
    name: 'Registration',
    data () {
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            role: null,
            terms: false,
            errors: [],
            isLoading: false,
            roles: []
        };
    },
    components: { loading },
    methods: {
        async requestRegister () {
            this.isLoading = true;
            axios.post('/api/register',
                {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    role_id: this.role,
                    terms: this.terms
                }).then(result => {
                alert(result.data.message);
                this.isLoading = false;
                this.message = result.data.message;
                this.$router.push('/');
            }, error => {
                this.errors.push(error);
            });
        }
    },
    mounted () {
        axios
            .get('/api/selectable-roles')
            .then(response => (this.roles = response.data));
    }
};
</script>

<style scoped>

</style>
