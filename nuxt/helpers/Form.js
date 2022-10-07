import axios from "axios"
import Errors from "./Errors"

export default class Form {
    constructor(data) {
        this.originalData = [data]

        for (let field in data) {
            this[field] = data[field]
        }

        this.errors = new Errors()
    }

    data() {
        let data = {}

        for (let property in this.originalData) {
            data[property] = this[property]
        }

        return data
    }

    reset() {

        for (let field in this.originalData) {

            // If in this.originalData we have an array => We have a nested form
            if (Array.isArray(this.originalData[field])) {
                // Foreach the array to clear all nested forms
                this.originalData[field].forEach((element) => {
                    // Loop the object in the array and clear all inputs
                    for (let type in element) {
                        element[type] = ''
                    }
                })

                // Check the number of nested forms objects we have
                const sizeObjects = Object.keys(this.originalData[field]).length

                // If we have more than one nested form, delete all the nested form excepted the first one
                if (sizeObjects > 1) {
                    this.originalData[field].splice(1, sizeObjects)
                }
            }

            this[field] = this.originalData[field]
        }

        this.errors.clear()
    }

    submit(requestType, url, resetForm = false) {
        return new Promise((resolve, reject) => {
            $axios[requestType](url, this.data())
                .then(response => {
                    this.onSuccess(response.data, resetForm)

                    resolve(response.data)
                })
                .catch(error => {
                    this.onFail(error.response.data.errors)

                    reject(error.response.data.errors)
                })
        })

    }

    onSuccess(data, resetForm) {
        if (resetForm) this.reset()
    }

    onFail(errors) {
        this.errors.record(errors)
    }
}