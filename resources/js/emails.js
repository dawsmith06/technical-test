const { default: axios } = require("axios");

new Vue({
    el: "#emails-container",
    data: {
        ready: true,
        emails: [],
        email: { to: null, subject: null, message: null },
        page: 1,
        pagination: {},
        search: "",
        columns: {
            id: { title: "ID" },
            from: { title: "From" },
            to: { title: "To" },
            subject: { title: "Subject" },
            message: { title: "Message" },
            status: { title: "Status" }
        },
        order: {}
    },

    methods: {
        /**
         * Fetch all users stored
         */
        getEmails() {
            this.showLoader(600);
            axios
                .get(`emails-list${this.request.toString()}`, {
                    params: {
                        page: this.page
                    }
                })
                .then(response => {
                    this.emails = response.data.data;
                    this.pagination = {
                        total: response.data.total,
                        per_page: response.data.per_page,
                        current_page: response.data.current_page
                    };
                })
                .finally(() => this.hideLoader());
        },

        store() {
            this.showLoader();
            axios
                .post(`emails`, this.email)
                .then(response => {
                    if (response.data.success) {
                        this.hideModal("#emails-form");
                        this.email = { to: null, subject: null, message: null };
                        this.alert("Email stored", " ", "success", 2000);
                        this.getEmails();
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
                        this.getEmails();
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
            this.getEmails();
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
            this.getEmails();
        }
    },

    watch: {
        search() {
            if (this.search) {
                this.request.set("search", this.search);
            } else {
                this.request.delete("search");
                this.getEmails();
            }
        }
    },

    computed: {
        changes() {
            return this.emails.filter(user => user.changed);
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
        this.getEmails();
    }
});
