import { useEffect, useState } from 'react';
import { Head, useForm, usePage } from '@inertiajs/react';
import { format } from "date-fns";
import axios from 'axios';
import FormReservation from './Reservation/FormReservation';

export default function Welcome({ auth }) {
    const { flash } = usePage().props
    const { data, setData, post, errors, recentlySuccessful, reset } = useForm({
        name: "",
        email: "",
        phone: "",
        date: format(new Date(), 'yyyy-MM-dd'),
        time: "",
        special_request: "",
    });
    const [timeslots, setTimeslots] = useState([]);

    const handleChange = (e) => {
        setData(e.target.name, e.target.value)
    }

    const handleSubmit = (e) => {
        e.preventDefault()
        post('/online-reservations');
        reset();
        loadTimeslots();
    }

    const loadTimeslots = () => {
        axios
            .get(`/api/v1/tables/available-timeslots?date=${data.date}`)
            .then((res) => {
                setTimeslots(res.data.data)
            }).catch(() => {
                alert("error");
            });
    }

    useEffect(() => {
        if (data.date) {
            loadTimeslots();
        }
    }, [data.date]);

    return (
        <>
            <Head title="Online Reservation" />
            <div >
                <div className="max-w-7xl mx-auto p-6 lg:p-8">
                    <div className="mx-auto mt-10 max-w-xl sm:mt-20">
                        <h2 className="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl text-center">
                            Online Reservation
                        </h2>
                        {recentlySuccessful && (
                            <div className="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                                <span className="font-medium">Success!</span> Successfully booked
                            </div>
                        )}

                        {flash.error && (
                            <div className="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                                <span className="font-medium">Error!</span> {flash.error}
                            </div>
                        )}
                    </div>

                    <FormReservation handleSubmit={handleSubmit} handleChange={handleChange} data={data} errors={errors} timeslots={timeslots} />

                </div>
            </div>
        </>
    );
}
