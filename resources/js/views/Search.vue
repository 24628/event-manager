<template>
    <div class="search">
        <label class="flex-wrapper search-label">
            <span class="search-label-text">Search:</span>
            <span class="search-input">
                <input  type="text" v-model="searchString">
                <select v-model="selectedRole">
                    <option value="">Alles</option>
                    <option v-for="role in roles">{{role}}</option>
                </select>
            </span>
        </label>
        <div class="search-results">
            <template v-for="(user,index) in data">
                <router-link class="search-result" :to="'profile/' + user.id">
                    <b>{{index + 1}}</b><p>{{user.name}}</p>
                </router-link>
            </template>
            <div class="search-result" v-if="!data.length">
                <b>Sorry,</b><p>Er zijn geen resulataten gevonden</p>
            </div>
        </div>
    </div>
</template>

<script>
    import API from '@/js/Api';

    export default {
        name: 'search',
        data() {
            return {
                searchString: '',
                newSearchString: '',
                oldSearchString: '',
                sendTimeout: null,
                selectedRole: '',
                //TODO: Get roles from DB
                roles: ['Bezoeker', 'StandHouder', 'Werkzoekende'],
                data: [],
            }
        },
        watch: {
            searchString() {
                this.send()
            }
        },
        methods: {
            send() {
                clearTimeout(this.sendTimeout);
                this.sendTimeout = setTimeout(() => {
                    this.newSearchString = this.searchString.trim();
                    if (this.newSearchString.length && this.newSearchString !== this.oldSearchString) {
                        this.oldSearchString = this.newSearchString;
                        this.sendApiCall(this.newSearchString);
                    }
                }, 500);

            },
            async sendApiCall(string){
                const response = await API.post({ search: string }, '/api/search/profile' );
               if (response.status === 200){
                   this.data = response.data.message;
               }

            }
        }
    }
</script>

<style lang="scss">
    @import "../../sass/variables";

    .search {
        background: $dark-gray;
        flex: 1;
        .search-label{
            display: flex;
            flex-wrap: wrap;
            .search-label-text {
                flex: 1 0 100%;
                font-weight: bold;
                color: $basic-gray;
                font-size: $font-size-big;
            }
            .search-input{
                display: flex;
                flex: 1;
                margin-top: $padding-small;

                input{
                    flex: 1;
                    border-radius: $border-radius-small 0 0 $border-radius-small;
                    border: none;
                    padding: $padding-small;
                }
                select{
                    flex: 0 0 max-content;
                    border-radius: 0 $border-radius-small $border-radius-small 0;
                    padding: $padding-small;
                    border: none;
                    width: max-content;
                }
            }
        }
    }
    .search-results{
        padding: $padding-medium $padding-big;
        display: flex;
        flex-wrap: wrap;
        .search-result{
            flex: 1 0 100%;
            margin-bottom: .5em;
            padding: $padding-tiny $padding-small;
            background: $pretty-black;
            width: 100%;
            color: $basic-gray;
            text-decoration: none;
            border-radius: $border-radius-small;
            b{
                color: $theme-color;
                padding-right: 1em;
            }
            p{
                display: inline-block;
            }
        }
    }
</style>