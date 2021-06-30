const { default: axios } = require("axios");

new Vue({
    el: "#users-container",
    data: {
        ready: true,
        users: [],
        page: 1,
        pagination: {},
        search: "",
        columns: {
            id: { title: "ID" },
            name: { title: "Name" },
            email: { title: "E-mail" },
            identification_card: { title: "Identification Card" },
            cellphone_number: { title: "Cellphone Number" },
            birth_date: { title: "Birth Date" },
            age: { title: "Age" },
            city: { title: "City" }
        },
        order: {}
    },

    methods: {
        /**
         * Fetch all users stored
        */
        getUsers() {
            this.showLoader(600);
            axios
                .get(`users-list${this.request.toString()}`, {
                    params: {
                        page: this.page
                    }
                })
                .then(response => {
                    this.users = response.data.data;
                    this.pagination = {
                        total: response.data.total,
                        per_page: response.data.per_page,
                        current_page: response.data.current_page
                    };
                })
                .finally(() => this.hideLoader());
        },
        
        /**
         *  Update all edited users in storage.
        */
        update() {
            this.showLoader();
            axios
                .put(`users`, {
                    users: this.users
                })
                .then(response => {
                    if (response.data.success) {
                        this.alert("Users updated", " ", "success", 2000);
                        this.getUsers();
                    }
                })
                .catch(error => {
                    this.alert(
                        "Something went wrong",
                        "Your changes could not be saved",
                        "error",
                        false
                    );
                })
                .finally(() => {
                    this.hideLoader();
                });
        },

        /**
         * Remove specified user from storage.
         * @param {object} user 
        */
        destroy(user) {
            this.showLoader();
            axios
                .delete("users/" + user.id)
                .then(response => {
                    if (response.data.success) {
                        this.alert("User deleted", " ", "success", 4000);
                        this.getUsers();
                    }
                })
                .finally(() => {
                    this.hideLoader();
                });
        },

        /**
         * Show confirmation before destroying user
         * @param {object} user 
        */
        confirmDestroy(user) {
            swal({
                title: "Are you Sure?",
                text: `Do you want to delete ${user.email} user?\n`,
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) this.destroy(user);
            });
        },

        /**
         * On pagination page change update users list
         * @param {Number} page 
        */
        onPageChange(page) {
            this.page = page;
            this.getUsers();
        },

        /**
         * On user value changed set attribute change to user object
         * @param {String} field 
         * @param {Object} user 
        */
        onChange(field, user) {
            Vue.set(user, field + "Changed", true);
            Vue.set(user, "changed", true);
        },

        /**
         * Order by table column on th click
         * @param {String} column 
        */
        orderBy(column) {
            let orderMode = this.order.mode == "ASC" ? "DESC" : "ASC";
            this.request.set("orderBy", column);
            this.request.set("orderMode", orderMode);
            this.order = {
                column: column,
                mode: orderMode
            };
            this.getUsers();
        }
    },

    watch: {
        search() {
            if (this.search) {
                this.request.set("search", this.search);
            } else {
                this.request.delete("search");
                this.getUsers();
            }
        }
    },

    computed: {
        changes() {
            return this.users.filter(user => user.changed);
        },

        hasChanges() {
            return this.changes.length > 0;
        },

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

    created() {
        if (this.request.has("orderBy")) {
            this.order = {
                column: this.request.get("orderBy"),
                mode: this.request.get("orderMode")
            };
        }

        if (this.request.has("search")) {
            this.search = this.request.get("search");
        }
    },

    mounted() {
        this.getUsers();
    }
});
