<template>
    <div
            v-if="!!data"
            class="event-page"
            :style="{ '--theme-color': data.settings.color }"
            :class="{ light: data.settings.light_theme }"
    >
        <div
                class="event-background"
                :style="{ backgroundImage: 'url(' + data.image + ')' }"
        />
        <div class="event-content flex-grid">
            <div
                    class="event-content-row flex-grid column-desktop-12 column-tablet-12 column-mobile-12"
            >
                <div
                        class="event-titlebar column-desktop-12 column-tablet-12 column-mobile-12"
                >
                    <div class="flex-grid">
                        <div
                                class="event-titlebar-part-holder column-desktop-4 column-tablet-12 column-mobile-12 title-holder"
                        >
                            <h1
                                    class="event-titlebar-title"
                                    v-text="data.name"
                            />
                        </div>
                        <div
                                class="event-titlebar-part-holder column-desktop-4 column-tablet-12 column-mobile-12 description-holder"
                        >
                            <h4
                                    class="event-titlebar-description"
                                    v-text="data.description"
                            />
                        </div>
                        <div
                                class="event-titlebar-part-holder part-half column-desktop-4 column-tablet-4 column-mobile-6"
                        >
                            <div
                                    v-if="
                                    currentTickets >=
                                        data.settings.visible_registrations
                                "
                                    class="event-titlebar-ticketcounter-holder"
                            >
                                <p class="event-titlebar-ticketcounter-text">
                                    Aantal tickets verkrijgbaar
                                </p>
                                <div class="event-titlebar-ticketcounter">
                                    <span
                                            class="event-titlebar-current-ticketcount"
                                    >{{ currentTickets }}/</span>
                                    <span
                                            class="event-titlebar-maximum-ticketcount"
                                    >{{
                                        data.settings.max_registrations
                                    }}</span>
                                </div>
                            </div>
                        </div>
                        <div
                                class="event-titlebar-whitespace column-desktop-12"
                        />
                        <div
                                class="event-titlebar-part-holder part-half column-desktop-4 column-tablet-8 column-mobile-6 date-holder"
                        >
                            <span
                                    class="event-titlebar-date"
                                    v-text="formatDate(data.settings)"
                            />
                        </div>
                        <div
                                class="event-titlebar-part-holder column-desktop-4 column-tablet-12 column-mobile-12"
                        >
                            <div class="event-titlebar-line">
                                <hr class="event-titlebar-divider">
                                <p class="event-titlebar-line-text desktop-3">
                                    <!--Selecteer hier naar welke sprekers u wilt-->
                                </p>
                            </div>
                        </div>
                        <div
                                class="event-titlebar-part-holder contains-btn column-desktop-4 column-tablet-12 column-mobile-12"
                        >
                            <button
                                    class="event-titlebar-btn"
                                    @click="() => {}"
                            >
                                Bekijk plattegrond
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div
                    class="event-content-row flex-grid column-desktop-12 column-tablet-12 column-mobile-12"
            >
                <div
                        class="event-program_and_info column-desktop-4 column-tablet-5 column-mobile-12"
                >
                    <div class="event-program_and_info-content">
                        <div
                                v-for="program in data.program"
                                :key="program.name + '_' + program.id"
                                class="event-program"
                        >
                            <b class="event-program-title">{{
                                program.name
                                }}</b>
                            <div
                                    v-for="part in program.program_items"
                                    :key="part.name + '_' + part.id"
                                    class="event-program-part"
                            >
                                <div class="event-program-part-text">
                                    <b class="event-program-part-title">{{
                                        part.name
                                        }}</b>
                                    <p class="event-program-part-description">
                                        {{ part.description }}
                                    </p>
                                </div>
                                <span class="event-program-part-time">{{
                                    getTime(part.date)
                                }}</span>
                            </div>
                        </div>
                        <div class="event-info">
                            <hr class="event-info-divider">
                            <b class="event-info-title">Info</b>
                            <div class="event-info-line">
                                <b class="event-info-line-title">Datum</b><br>
                                <span class="event-info-line-content">
                                    {{ formatDate(data.settings) }}
                                </span>
                            </div>
                            <div class="event-info-line">
                                <b class="event-info-line-title">Locatie</b><br>
                                <span class="event-info-line-content">{{
                                    data.settings.location
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                        class="event-congress column-desktop-8 column-tablet-7 column-mobile-12 flex-grid"
                >
                    <b
                            class="event-congress-title column-desktop-12 column-tablet-12 column-mobile-12"
                    >Congress</b>
                    <p
                            class="event-congress-description column-desktop-4 column-tablet-4 column-mobile-4"
                    >
                        Bekijk en selecteer lezingen per ronde voor dit
                        evenement.
                    </p>
                    <div
                            class="event-congress-rounds column-desktop-12 column-tablet-12 column-mobile-12 flex-grid"
                    >
                        <template v-for="congress in data.congress">
                            <div
                                    v-for="(round, index) in congress.block"
                                    :key="congress.id + '_round_' + index"
                                    class="event-congress-round  column-desktop-4 column-tablet-12 column-mobile-12"
                            >
                                <div class="event-congress-round-content">
                                    <b
                                            class="event-congress-round-title"
                                    ><b>Ronde {{ index + 1 }}</b>
                                        <span>{{
                                            getTime(round.date_start)
                                        }}</span>
                                    </b>
                                    <div class="event-congress-round-speakers">
                                        <div
                                                v-for="speaker in round.items.filter(
                                                s => s.type === 'speaker'
                                            )"
                                                :key="speaker.id"
                                                class="event-congress-round-speaker"
                                        >
                                            <div
                                                    class="event-congress-round-speaker-content"
                                            >
                                                <b
                                                        class="event-congress-round-speaker-title"
                                                >{{ speaker.name }}</b>
                                                <span
                                                        class="event-congress-round-speaker-position"
                                                >{{
                                                    speaker.description
                                                }}</span>
                                            </div>
                                            <div
                                                    class="event-congress-round-checkbox-holder"
                                            >
                                                <button
                                                        class="event-congress-round-speaker-checkbox"
                                                        :class="{
                                                        active:
                                                            selectedSpeakers.length &&
                                                            !!selectedSpeakers[
                                                                index
                                                            ] &&
                                                            selectedSpeakers[
                                                                index
                                                            ].id === speaker.id
                                                    }"
                                                        @click="
                                                        setSpeaker(
                                                            index,
                                                            speaker,
                                                            getTime(
                                                                round.date_start
                                                            )
                                                        )
                                                    "
                                                >
                                                    <div/>
                                                    <div/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <template
                                            v-for="keynote in round.items.filter(  s => s.type === 'keynotes' )"
                                    >
                                        <b
                                                :key="keynote.id + '_title'"
                                                class="event-congress-round-title"
                                        >
                                            <b>Keynotespreker</b>
                                            <span>{{
                                                getTime(keynote.date_start)
                                            }}</span>
                                        </b>
                                        <div
                                                :key="keynote.id + '_content'"
                                                class="event-congress-round-keynote"
                                        >
                                            <div
                                                    class="event-congress-round-speaker-content"
                                            >
                                                <b
                                                        class="event-congress-round-speaker-title"
                                                >{{ keynote.name }}</b>
                                                <span
                                                        class="event-congress-round-speaker-position"
                                                >{{
                                                    keynote.description
                                                }}</span>
                                            </div>
                                            <div
                                                    class="event-congress-round-checkbox-holder"
                                            >
                                                <button
                                                        class="event-congress-round-speaker-checkbox"
                                                        :class="{
                                                        active:
                                                            selectedKeyNotes.length &&
                                                            !!selectedKeyNotes[
                                                                index
                                                            ] &&
                                                            selectedKeyNotes[
                                                                index
                                                            ].id === keynote.id
                                                    }"
                                                        @click="
                                                        setSpeaker(
                                                            index,
                                                            keynote,
                                                            getTime(
                                                                keynote.date_start
                                                            ),
                                                            true
                                                        )
                                                    "
                                                >
                                                    <div/>
                                                    <div/>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div
                    class="event-content-row row-reverse flex-grid column-desktop-12 column-tablet-12 column-mobile-12"
            >
                <div
                        class="event-my_speakers column-desktop-8 column-tablet-7 column-mobile-12 flex-grid"
                >
                    <b
                            class="event-my_speakers-title column-desktop-4 column-tablet-12 column-mobile-12"
                    >Geselecteerde Sprekers</b>
                    <div
                            class="event-my_speakers-rounds column-desktop-12 column-tablet-12 column-mobile-12 flex-grid"
                    >
                        <div
                                v-for="(speaker, index) in selectedSpeakers"
                                :key="'round' + index + '_speaker'"
                                class="event-my_speakers-round column-desktop-4 column-tablet-12 column-mobile-12"
                        >
                            <div class="event-my_speaker-round-content">
                                <b
                                        class="event-my_speakers-round-title"
                                >Ronde
                                    {{ index + 1 }}
                                    <span
                                            v-if="!!speaker"
                                            class="event-my_speakers-round-title-time"
                                    >{{ speaker.time }}</span>
                                </b>
                                <div
                                        v-if="!!speaker"
                                        class="event-my_speakers-round-speaker"
                                >
                                    <div
                                            class="event-my_speakers-speaker-content"
                                    >
                                        <b
                                                class="event-my_speakers-round-speaker-title"
                                        >{{ speaker.name }}</b>
                                        <span
                                                class="event-my_speakers-round-speaker-description"
                                        >{{ speaker.description }}</span>
                                    </div>
                                    <div
                                            class="event-my_speakers-round-speaker-button-holder"
                                    >
                                        <button
                                                class="event-my_speakers-round-speaker-button"
                                                @click="removeSelection(index)"
                                        >
                                            <div/>
                                        </button>
                                    </div>
                                </div>
                                <div
                                        v-if="!speaker"
                                        class="event-my_speakers-round-speaker"
                                >
                                    <h4>
                                        Er is nog geen spreker uit gekozen voor
                                        deze ronde
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                            class="event-my_speakers-rounds column-desktop-12 column-tablet-12 column-mobile-12 flex-grid"
                    >
                        <div
                                class="event-my_speakers-round event-padding-right-big column-desktop-4 column-tablet-12 column-mobile-12"
                                v-if="data.congress[0].block.filter(v => v.items.filter(v=> v.type === 'keynotes').length).length !== 0"
                        >
                            <b
                                    class="event-my_speakers-round-title"
                            >Keynote sprekers</b>
                            <template v-if="selectedKeyNotes.some(e => !!e)">
                                <div
                                        v-for="(keynote, index) in selectedKeyNotes"
                                        v-if="!!keynote"
                                        :key="'keynote_' + index"
                                        class="event-my_speakers-round-speaker"
                                >
                                    <div
                                            :key="'keynote_' + index"
                                            class="event-my_speakers-speaker-content"
                                    >
                                        <b
                                                class="event-my_speakers-round-speaker-title"
                                        >{{ keynote.name }}</b>
                                        <span
                                                class="event-my_speakers-round-speaker-description"
                                        >{{ keynote.description }}</span>
                                    </div>
                                    <div
                                            class="event-my_speakers-round-speaker-button-holder"
                                    >
                                        <button
                                                class="event-my_speakers-round-speaker-button"
                                                @click="
                                                removeSelection(index, true)
                                            "
                                        >
                                            <div/>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <div v-else class="event-my_speakers-round-speaker">
                                <h4>Er is nog geen keynote gekozen</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!--TODO: Modal?-->
                <div
                        class="event-modal column-desktop-4 column-tablet-5 column-mobile-12"
                >
                    <template v-if="subscribed || updating">
                        <div class="event-modal-text">
                            Je hebt je al ingeschreven voor dit evenement, je kan alsnog je selectie bijwerken of uitschrijven van het evenement
                        </div>
                        <button @click="updateEvent" class="event-modal-signup-button" :disabled="!!updating">
                            selectie bijwerken
                        </button>
                        <button @click="unsubscribeEvent" class="event-modal-signup-button" :disabled="!!updating">
                            uitschrijven
                        </button>
                        <div class="event-modal-text-holder">
                            <div class="event-modal-text feedback" :class="{'showing' : updating === 1}">Je selectie word bijgewerkt</div>
                            <div class="event-modal-text feedback" :class="{'showing' : updating === 2}">Je selectie is bijgewerkt</div>
                        </div>
                    </template>
                    <template v-else>
                        <div
                                class="event-modal-text"
                                v-if="
                                !(!!this.$user.data && !!this.$user.data.name)
                            "
                        >
                            Je moet ingelogd zijn om je in te kunnen schrijven.
                        </div>
                        <button
                                :disabled="
                                !(!!this.$user.data && !!this.$user.data.name)
                            "
                                class="event-modal-signup-button"
                                :class="{
                                inactive: !(
                                    !!this.$user.data && !!this.$user.data.name
                                )
                            }"
                                @click="subscribeEvent"
                        >
                            inschrijven
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import API from '@/js/Api';

    export default {
        name: 'Event',
        async mounted() {
            const response = await API.get(
                '/api/event-overview/' + this.$route.params.id
            );
            if (response === undefined) {
                this.$router.replace('/404');
            }
            this.data = response.data;
            this.selectedSpeakers = new Array(this.data.congress[0].block.length);
            this.selectedKeyNotes = new Array(this.data.congress[0].block.length);
            if (!!this.$user.data && !!this.$user.data.name) {
                this.getSubscripedData();
            }
        },
        methods: {
            async updateEvent(){
                this.updating = 1;
                console.log(this.updating);
                let selectedSpeakers = this.selectedSpeakers;
                let selectedKeyNotes = this.selectedKeyNotes;
                await this.unsubscribeEvent();
                await this.subscribeEvent(selectedSpeakers,selectedKeyNotes);
                this.updating = 2;
                let _this = this;
                setTimeout(()=>{_this.updating = 0},1500)
            },
            async getSubscripedData() {
                const res = await API.get(
                    '/api/is-subscribed/' + this.$route.params.id
                );
                if (res.data !== false) {
                    this.subscribed = true;
                    const selected = JSON.parse(res.data.item_ids);
                    for (
                        let roundNumbmer = 0;
                        roundNumbmer < this.data.congress[0].block.length;
                        roundNumbmer++
                    ) {
                        const round = this.data.congress[0].block[roundNumbmer];
                        for (let i = 0; i < round.items.length; i++) {
                            if (selected.includes(round.items[i].id)) {
                                if (round.items[i].type === 'keynotes') {
                                    this.setSpeaker(
                                        roundNumbmer,
                                        round.items[i],
                                        this.getTime(round.items[i].date_start),
                                        true
                                    );
                                } else {
                                    this.setSpeaker(
                                        roundNumbmer,
                                        round.items[i],
                                        round.date_start,
                                        false
                                    );
                                }
                            }
                        }
                    }
                }
            },
            async unsubscribeEvent() {
                const res = await API.delete(
                    '/api/event/unsubscribe/' + this.$route.params.id
                );
                if (res.status === 200) {
                    this.subscribed = false;
                }
            },
            async subscribeEvent(selectedSpeakers = null, selectedKeyNotes = null) {
                if (!!selectedSpeakers || !!selectedKeynotes){
                    selectedSpeakers = this.selectedSpeakers;
                    selectedKeyNotes = this.selectedKeyNotes;
                }
                const selectedIDs = [
                    ...selectedSpeakers.filter(v => !!v).map(v => v.id),
                    ...selectedKeyNotes.filter(v => !!v).map(v => v.id)
                ];
                const res = await API.post(
                    {
                        event_id: this.$route.params.id,
                        item_ids: JSON.stringify(selectedIDs)
                    },
                    '/api/event/subscribe/'
                );
                if (res.status === 200) {
                    this.subscribed = true;
                }
            },
            formatDate (settings) {
                let dateStart = new Date(settings.date_start).getTime();
                let dateEnd = new Date(settings.date_end).getTime();
                const months = ['Jan','Feb', 'Mar', 'Apr', 'Mei','Jun','Jul','Aug','Sep', 'Oct', 'Nov','Dec'];
                if (dateStart + 1000*60*60*24 > dateEnd){
                    return stringifyDate(dateStart);
                }  else {
                    return stringifyDate(dateStart) + " tot "  + stringifyDate(dateEnd)
                }

                function stringifyDate(date) {
                    date = new Date(date);
                    const formattedDate = date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
                    return formattedDate;
                }
            },
            getTime(dateObj) {
                const date = new Date(dateObj);
                let hours = date.getHours().toString();
                let minutes = date.getMinutes().toString();
                if (hours.length === 1) {
                    hours = '0' + hours;
                }
                if (minutes.length === 1) {
                    minutes = '0' + minutes;
                }
                return hours + ':' + minutes;
            },
            setSpeaker(index, speaker, time, isKeynote = false) {
                speaker = JSON.parse(JSON.stringify(speaker));
                speaker.isKeynote = isKeynote;
                speaker.time = time;
                if (isKeynote) {
                    this.selectedKeyNotes[index] = speaker;
                } else {
                    this.selectedSpeakers[index] = speaker;
                }
                this.$forceUpdate();
            },
            removeSelection(index, isKeynote = false) {
                if (isKeynote) {
                    this.selectedKeyNotes[index] = null;
                    this.$forceUpdate();
                } else {
                    this.selectedSpeakers[index] = null;
                    this.$forceUpdate();
                }
            }
        },
        data() {
            return {
                updating: 0,
                data: null,
                subscribed: false,
                selectedSpeakers: [],
                selectedKeyNotes: [],
                currentTickets: 135,
            };
        }
    };
</script>

<style>
    .event-padding-right-big {
        padding-right: 45px !important;
    }
</style>
