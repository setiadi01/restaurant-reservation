import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { useEffect, useState } from 'react';
import { Head, useForm, usePage } from '@inertiajs/react';
import { format } from "date-fns";
import axios from 'axios';
import FormReservation from './FormReservation';

export default function WalkInReservation({ auth }) {
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
        setData(e.target.name, e.target.value);
    }

    const handleSubmit = (e) => {
        e.preventDefault()
        post('/reservations');
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
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Add Walk In Reservation</h2>}
        >
            <Head title="Walk In Reservation" />

            <div className="pb-12">
                <div className="max-w-7xl mx-auto pt-10 sm:pt-20">
                    <div className="mx-auto mt-10 max-w-xl sm:mt-20">
                        {flash.error && (
                            <div className="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                                <span className="font-medium">Error!</span> {flash.error}
                            </div>
                        )}
                    </div>
                    <FormReservation handleSubmit={handleSubmit} handleChange={handleChange} data={data} errors={errors} timeslots={timeslots} />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
