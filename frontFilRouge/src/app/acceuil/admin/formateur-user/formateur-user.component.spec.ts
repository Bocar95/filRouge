import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormateurUserComponent } from './formateur-user.component';

describe('FormateurUserComponent', () => {
  let component: FormateurUserComponent;
  let fixture: ComponentFixture<FormateurUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormateurUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormateurUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
