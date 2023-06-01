const JSON_HEADERS = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
};

const NO_GROUP = {"p_id": -1, "p_name": null, "p_tasks_count": -1}

const NO_TASK = {"t_id": -1, "t_date": null, "t_subject": null, "t_priority": -1, "t_comments": null}

new Vue({
    el: "#app",
    delimiters: ['${', '}'],
    data: {
        projects: null,
        p_name: null,
        current_project: NO_GROUP,
        project_details: false,
        tasks: null,
        t_subject: null,
        current_subject: null,
        current_task: NO_TASK,
        whoiam: "?",
        task_error: null,
        task_edit: false,
    },
    methods: {
        askWhoIAm() {
            fetch("api/whoiam")
                .then(async (resp) => {
                    if (resp.status === 200) {
                        this.whoiam = await resp.text()
                    } else {
                        let j = await resp.text()
                        console.log(resp.status + "\n" + j);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        renderGroups() {
            fetch("api/projects")
                .then(async (resp) => {
                    if (resp.status === 200) {
                        this.$data.projects = await resp.json()
                    } else {
                        let j = await resp.text()
                        alert(resp.status + "\n" + j);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        renderGroupDetails(p_id) {
            this.renderCurrentGroup(p_id)
            this.renderGroupTasks(p_id);
            this.project_details = true;
            this.task_edit = false;
        },
        renderCurrentGroup(p_id) {
            fetch("api/projects/" + p_id)
                .then(async (resp) => {
                    if (resp.status === 200) {
                        this.$data.current_project = await resp.json()
                    } else {
                        let j = await resp.text()
                        alert(resp.status + "\n" + j);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        renderGroupTasks(p_id) {
            fetch("api/projects/" + p_id + "/tasks")
                .then(async (resp) => {
                    if (resp.status === 200) {
                        this.$data.tasks = await resp.json()
                    } else {
                        let j = await resp.text()
                        alert(resp.status + "\n" + j);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        renderTaskDetails(t_id) {
            fetch("api/tasks/" + t_id)
                .then(async (resp) => {
                    if (resp.status === 200) {
                        let task = await resp.json()
                        this.current_subject = task.t_subject;
                        this.current_task = task;
                        this.task_error = null;
                        this.task_edit = true;
                    } else {
                        let j = await resp.text()
                        alert(resp.status + "\n" + j);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        projectCreate() {
            let json = JSON.stringify({"p_name": this.$data.p_name})
            fetch("api/projects", {
                method: 'post',
                headers: JSON_HEADERS,
                body: json
            })
                .then(async (resp) => {
                    if (resp.status === 201) {
                        this.renderGroups();
                    } else {
                        let j = await resp.text()
                        alert(resp.status + "\n" + j);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        projectUpdate() {
            let p_id = this.$data.current_project.p_id
            let json = JSON.stringify(this.$data.current_project)
            fetch("api/projects/" + p_id, {
                method: 'put',
                headers: JSON_HEADERS,
                body: json
            })
                .then(async (resp) => {
                    if (resp.status === 200) {
                        this.renderGroups();
                    } else {
                        let j = await resp.text()
                        alert(resp.status + "\n" + j);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        projectDelete() {
            let p_id = this.$data.current_project.p_id
            fetch("api/projects/" + p_id, {
                method: 'delete'
            })
                .then(async (resp) => {
                    if (resp.status === 204) {
                        this.task_edit = false;
                        this.project_details = false;
                        this.renderGroups();
                    } else {
                        let j = await resp.text()
                        alert(resp.status + "\n" + j);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        taskCreate() {
            let p_id = this.$data.current_project.p_id
            let json = JSON.stringify({"t_subject": this.$data.t_subject})
            fetch("api/projects/" + p_id + "/tasks", {
                method: 'post',
                headers: JSON_HEADERS,
                body: json
            })
                .then(async (resp) => {
                    if (resp.status === 201) {
                        this.renderGroups(); // update tasks count
                        this.renderGroupDetails(p_id);
                    } else {
                        let text = await resp.text()
                        alert(resp.status + "\n" + text);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        taskUpdate() {
            if (!isNaN(this.$data.current_task.t_priority)) {
                this.$data.current_task.t_priority = parseInt(this.$data.current_task.t_priority);
            }
            let json = JSON.stringify(this.$data.current_task)
            let p_id = this.$data.current_project.p_id
            let t_id = this.$data.current_task.t_id
            fetch("api/tasks/" + t_id, {
                method: 'put',
                headers: JSON_HEADERS,
                body: json
            })
                .then(async (resp) => {
                    if (resp.status === 200) {
                        this.renderGroupTasks(p_id);
                        this.renderTaskDetails(t_id);
                    } else {
                        let text = await resp.text()
                        this.$data.task_error = (resp.status + "\n" + text);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        taskDelete() {
            let p_id = this.$data.current_project.p_id
            let t_id = this.$data.current_task.t_id
            fetch("api/tasks/" + t_id, {
                method: "delete"
            })
                .then(async (resp) => {
                    if (resp.status === 204) {
                        this.task_edit = true;
                        this.renderGroups(); // update tasks count
                        this.renderGroupDetails(p_id);
                    } else {
                        let text = await resp.text()
                        alert(resp.status + "\n" + text);
                    }
                })
                .catch((reason) => {
                    console.log(reason)
                })
        },
        hideProjectDetails() {
            this.project_details = false
            this.task_edit = false
        },
        hideTaskDetails() {
            this.task_edit = false
        },
    },
    created() {
    },
    updated() {
    },
    mounted() { // https://codepen.io/g2g/pen/mdyeoXB
        //this.askWhoIAm();
        this.renderGroups();
    },
})