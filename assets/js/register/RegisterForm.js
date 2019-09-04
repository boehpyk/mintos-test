import React, { Component } from 'react';
import {render} from 'react-dom';

const REGISTER_API        = '/api/register';
const CHECK_EMAIL_API     = '/api/check_email';


class Form extends Component {

    state = {
        emailValue: '',
        passwordValue: '',
        emailError: null,
        passwordError: null,
        successMessage: null,
    };

    handleChange = (e) => {
        if(e.target.name === 'email') {
            this.setState(
                {
                    emailValue: e.target.value,
                },
                () => { this.checkExistEmail(this.state.emailValue) }
            );
        }

        if(e.target.name === 'password') {
            this.setState({
                passwordValue: e.target.value,
            });
        }
    };

    handleSubmit = (e) => {
        e.preventDefault();

        fetch(REGISTER_API, {
                method: 'POST',
                headers: {'Content-Type':'application/json'},
                body: JSON.stringify({
                    "email": this.state.emailValue,
                    "password": this.state.passwordValue
                })
            }
        )
        .then((res) => {
            return res.json();
        })
        .then((response) => {
            this.setState({
                emailError: response.emailError ? response.emailError : null,
                passwordError: response.passwordError ? response.passwordError : null,
                successMessage: response.successMessage ? response.successMessage : null,
            });
        })
        .catch((err)=>console.log(err));
    };

    checkExistEmail = () => {
        fetch(CHECK_EMAIL_API, {
                method: 'POST',
                headers: {'Content-Type':'application/json'},
                body: JSON.stringify({
                    'email': this.state.emailValue
                })
            }
        )
        .then((res) => {
            return res.json();
        })
        .then((response) => {
            this.setState({
                emailError: response.emailError ? response.emailError : null,
            });
        })
        .catch((err)=>console.log(err));
    };

    showRegisterForm = () => {

        return  (
            <form onSubmit={this.handleSubmit}>
                <div className="form-group col-md-6">
                    <label className="col-md-2 sr-only" htmlFor="email">Email</label>
                    <input
                        type="email"
                        name='email'
                        className={`form-control${(this.state.emailError) ? ' is-invalid' : ''}`}
                        value={this.state.emailValue}
                        onChange={ this.handleChange }
                        id="email"
                        placeholder="Email"
                    />
                    <small className="text-danger">{this.state.emailError}</small>
                </div>

                <div className="form-group col-md-6">
                    <label className="col-md-2 sr-only" htmlFor="password">Password</label>
                    <input
                        type="password"
                        name='password'
                        className={`form-control${(this.state.passwordError) ? ' is-invalid' : ''}`}
                        value={this.state.passwordValue}
                        onChange={ this.handleChange }
                        id="password"
                        placeholder="Password"
                    />
                    <small className="text-danger">{this.state.passwordError}</small>
                </div>

                <button
                    className="btn btn-primary"
                    type="submit"
                    disabled={ this.state.emailValue === '' || this.state.emailError }
                >
                    Sign up
                </button>
                <span className='text-success'>{this.state.successMessage}</span>
            </form>
        )
    };

    showSuccessMessage = () => {
        return (
            <div className="alert alert-success">
                <h5>Thank you for registering!</h5>
                Now you can <a href='/login'>login</a>!
            </div>
        )
    }



    render() {
        return (
            <div>
                { this.state.successMessage ? this.showSuccessMessage() : this.showRegisterForm() }
            </div>
        );
    }
}

render(<Form />, document.getElementById('form'));