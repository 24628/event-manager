import Vue from 'vue';
import VueRouter from "vue-router";

import Home from '@/js/views/Home';
import Event from '@/js/views/Event';
import Profile from '@/js/views/Profile';
import About from '@/js/views/About';
import EventForm from '@/js/views/forms/Event-form'
import ResetPasswordForm from '@/js/views/forms/ResetPasswordForm';
import EventSettingsForm from '@/js/views/forms/Event-Settings-form'
import RoleForm from '@/js/views/forms/Role-form'
import MapForm from '@/js/views/forms/Map-form'
import ProfileForm from '@/js/views/forms/Profile-form'
import CVForm from '@/js/views/forms/CV-form'
import datepickerExample from '@/js/views/DateTimeExample'
import AdminIndex from '@/js/views/Admin/Admin';
import UserRegistrationForm from '@/js/views/forms/User-Registration-form';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/event',
            name: 'event',
            component: Event
        },
        {
          path: '/profile',
          name: 'profile',
          component: Profile
        },
        {
            path: '/about',
            name: 'about',
            component: About,
        },
        {
            path: '/form/event',
            name: 'event-form',
            component: EventForm,
        },
        {
            path: '/form/map/:event_id',
            name: 'map-form',
            component: MapForm
        },
        {
            path: '/form/role',
            name: 'role-form',
            component: RoleForm
        },
        {
            path: '/form/profile',
            name: 'profile-form',
            component: ProfileForm
        },
        {
            path: '/form/profile-cv',
            name: 'profile-cv-form',
            component: CVForm
        },
        {
            path: '/form/event-settings/:event_id',
            name: 'event-settings-form',
            component: EventSettingsForm,
            meta: {
                auth: true
            }
        },
        {
            path: '/reset-password/:token',
            name: 'reset-password-form',
            component: ResetPasswordForm,
        },
        {
            path: '/user-registration',
            name: 'user-registration-form',
            component: UserRegistrationForm
        },
        {
            path: '/admin',
            name: 'admin',
            component: AdminIndex,
        },
        {
            path: '/datepicker',
            name: 'datepicker',
            component: datepickerExample
        },

    ]
});

export default router;
