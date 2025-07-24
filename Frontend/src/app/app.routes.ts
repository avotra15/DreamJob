import { Routes } from '@angular/router';
import { LoginComponent } from './pages/login/login.component';
import { HomeComponent } from './componenets/home/home.component';
import { AppComponent } from './app.component';
import { AboutComponent } from './pages/about/about.component';
import { BlogComponent } from './pages/blog/blog.component';
import { BlogSingleComponent } from './pages/blog-single/blog-single.component';
import { ContactComponent } from './pages/contact/contact.component';
import { FaqComponent } from './pages/faq/faq.component';
import { GalleryComponent } from './pages/gallery/gallery.component';
import { JobListingsComponent } from './pages/job-listings/job-listings.component';
import { JobSingleComponent } from './pages/job-single/job-single.component';
import { PortfolioComponent } from './pages/portfolio/portfolio.component';
import { PortfolioSingleComponent } from './pages/portfolio-single/portfolio-single.component';
import { PostJobComponent } from './pages/post-job/post-job.component';
import { ServiceSingleComponent } from './pages/service-single/service-single.component';
import { ServicesComponent } from './pages/services/services.component';
import { TestimonialsComponent } from './pages/testimonials/testimonials.component';
import { RegistrerComponent } from './pages/registrer/registrer.component';

export const routes: Routes = [
    {path: '', redirectTo: 'home', pathMatch: 'full'},
    {path: 'home', component: HomeComponent},
    {path: 'login', component: LoginComponent},
    {path: 'registrer', component: RegistrerComponent},
    {path: 'about', component: AboutComponent},
    {path: 'blog', component: BlogComponent},
    {path: 'blog-single', component: BlogSingleComponent},
    {path: 'contact', component: ContactComponent},
    {path: 'faq', component: FaqComponent},
    {path: 'gallery', component: GalleryComponent},
    {path: 'job-listings', component: JobListingsComponent},
    {path: 'job-single', component: JobSingleComponent},
    {path: 'portfolio', component: PortfolioComponent},
    {path: 'portfolio-single', component: PortfolioSingleComponent},
    {path: 'post-job', component: PostJobComponent},
    {path: 'service-single', component: ServiceSingleComponent},
    {path: 'services', component: ServicesComponent},
    {path: 'testimonials', component: TestimonialsComponent},
];
