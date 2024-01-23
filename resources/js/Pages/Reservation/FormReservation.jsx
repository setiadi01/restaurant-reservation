import TimeslotItem from '@/Components/TimeslotItem';
import React from 'react';

function FormReservation({ handleSubmit, handleChange, data, errors, timeslots }) {
    return (
        <form onSubmit={handleSubmit} className="mx-auto max-w-xl">
            <div className="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                <div className="sm:col-span-2">
                    <label
                        htmlFor="company"
                        className="block text-sm font-semibold leading-6 text-gray-900"
                    >
                        Name *
                    </label>
                    <div className="mt-2.5">
                        <input
                            type="text"
                            name="name"
                            id="name"
                            autoComplete="name"
                            value={data.name}
                            onChange={handleChange}
                            className="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                        {errors.name && <div className="text-red-500" >{errors.name}</div>}
                    </div>
                </div>
                <div className="sm:col-span-2">
                    <label
                        htmlFor="email"
                        className="block text-sm font-semibold leading-6 text-gray-900"
                    >
                        Email *
                    </label>
                    <div className="mt-2.5">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            autoComplete="email"
                            value={data.email}
                            onChange={handleChange}
                            className="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                        {errors.email && <div className="text-red-500">{errors.email}</div>}
                    </div>
                </div>
                <div className="sm:col-span-2">
                    <label
                        htmlFor="phone-number"
                        className="block text-sm font-semibold leading-6 text-gray-900"
                    >
                        Phone number
                    </label>
                    <div className="mt-2.5">
                        <input
                            type="tel"
                            name="phone"
                            id="phone"
                            autoComplete="tel"
                            value={data.phone}
                            onChange={handleChange}
                            className="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                        {errors.phone && <div className="text-red-500">{errors.phone}</div>}
                    </div>
                </div>
                <div className="sm:col-span-2">
                    <label
                        htmlFor="phone-number"
                        className="block text-sm font-semibold leading-6 text-gray-900"
                    >
                        Date *
                    </label>
                    <div className="mt-2.5">
                        <input
                            type="date"
                            name="date"
                            id="date"
                            onChange={handleChange}
                            value={data.date}
                            className="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                        {errors.date && <div className="text-red-500">{errors.date}</div>}
                    </div>
                </div>
                <div className="sm:col-span-2">
                    <label
                        htmlFor="message"
                        className="block text-sm font-semibold leading-6 text-gray-900"
                    >
                        Time *
                    </label>
                    <div className="mt-2.5">
                        <div className="grid grid-cols-4 gap-4">
                            {timeslots.map(timeslot => (
                                <TimeslotItem key={timeslot.start_time} time={timeslot.start_time} available={timeslot.available} value={data.time} onChange={handleChange} />
                            ))}
                        </div>
                        {errors.time && <div className="text-red-500">{errors.time}</div>}
                    </div>
                </div>
                <div className="sm:col-span-2">
                    <label
                        htmlFor="message"
                        className="block text-sm font-semibold leading-6 text-gray-900"
                    >
                        Special Request
                    </label>
                    <div className="mt-2.5">
                        <textarea
                            name="special_request"
                            id="special_request"
                            rows={4}
                            value={data.special_request}
                            onChange={handleChange}
                            className="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                        {errors.special_request && <div className="text-red-500">{errors.special_request}</div>}
                    </div>
                </div>
            </div>
            <div className="mt-10">
                <button
                    type="submit"
                    className="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    Book
                </button>
            </div>
        </form>
    );
}

export default FormReservation;