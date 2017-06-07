export class CheckIn {
	constructor(
		public checkInId: number,
		public checkInDogId: number,
		public checkInParkId: number,
		public checkInDateTime: string,
		public checkOutDateTime: string
	){}
}