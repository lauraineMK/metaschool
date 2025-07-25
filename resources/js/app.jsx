import React from 'react';
import { createRoot } from 'react-dom/client';

function CourseGrid({ courses }) {
    if (!courses || courses.length === 0) {
        return <div className="alert alert-info">Aucun cours à afficher.</div>;
    }
    return (
        <div className="row g-4">
            {courses.map(course => (
                <div className="col-md-4" key={course.id}>
                    <div className="card h-100 shadow-sm border-0">
                        <div className="card-body">
                            <h5 className="card-title">{course.name}</h5>
                            <p className="card-text text-muted">{course.description}</p>
                            <a href={`/students/courses/${course.id}`} className="btn btn-primary rounded-pill mt-2">Voir le cours</a>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
}

const el = document.getElementById('react-course-grid');
if (el) {
    const courses = JSON.parse(el.dataset.courses);
    createRoot(el).render(<CourseGrid courses={courses} />);
}
