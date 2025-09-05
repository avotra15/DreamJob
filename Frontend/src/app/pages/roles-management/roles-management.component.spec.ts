import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RolesManagementComponent } from './roles-management.component';

describe('RolesManagementComponent', () => {
  let component: RolesManagementComponent;
  let fixture: ComponentFixture<RolesManagementComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [RolesManagementComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RolesManagementComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
