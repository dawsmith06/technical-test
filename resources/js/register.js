const { default: axios } = require("axios");

new Vue({
    el: "#register-container",
    data: {
        ready: true,
        user: {
            name: null,
            email: null,
            city_id: "",
            cellphone_number: null,
            identification_card: null,
            birth_date: null,
            password: null,
            password_confirmation: null
        },
        errors: {},
        countryId: "",
        stateId: "",
        countries: [],
        cities: [],
        states: []
    },
    methods: {
        register() {
            axios
                .post("/register", this.user)
                .then(response => {
                    if (response.data.success) {
                        this.alert(
                            "User Registered successfull",
                            " ",
                            "success"
                        ).then(() => {
                            location.href = location.origin + "/users";
                        });
                    }
                })
                .catch(error => {
                    if (error.response && error.response.data) {
                        this.errors = error.response.data.errors;
                    }
                });
        },

        getStates() {
            this.showLoader(600);
            axios
                .get(`/states/${this.countryId}`)
                .then(response => (this.states = response.data))
                .finally(() => this.hideLoader());
        },

        getCities() {
            this.showLoader(600);
            axios
                .get(`/cities/${this.stateId}`)
                .then(response => (this.cities = response.data))
                .finally(() => this.hideLoader());
        }
    },

    watch: {
        countryId() {
            this.getStates();
        },
        stateId() {
            this.getCities();
        }
    },

    computed: {
        maxDate() {
            return `${this.actualYear - 18}-${this.actualMonth}-${
                this.actualDay
            }`;
        },

        actualYear() {
            return new Date().getFullYear();
        },

        actualMonth() {
            return this.pad(new Date().getMonth(), 2, 0);
        },

        actualDay() {
            return this.pad(new Date().getDay(), 2, 0);
        }
    },

    mounted() {
        this.ready = true;
    }
});
