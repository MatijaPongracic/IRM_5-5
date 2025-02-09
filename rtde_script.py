import rtde_receive
import json
import math

# Postavite IP adresu robota
ROBOT_IP = "192.168.40.50"

def get_robot_data():
    try:
        # Kreiranje RTDE prijemnika
        rtde_r = rtde_receive.RTDEReceiveInterface(ROBOT_IP)

        # Dobijanje pozicije alata i zglobova
        tcp_pose = rtde_r.getActualTCPPose()
        joint_positions = rtde_r.getActualQ()

        # Modifikacija tcp_pose vrijednosti: množenje prvih 3 vrijednosti s 1000 i zaokruživanje na 2 decimale
        tcp_pose = [round(value * 1000, 2) if i < 3 else round(value, 3) for i, value in enumerate(tcp_pose)]

        # Pretvaranje joint_positions iz radijana u stepene, množenje s (180/pi) i zaokruživanje na 2 decimale
        joint_positions = [round(value * (180 / math.pi), 2) for value in joint_positions]

        # Formatiranje rezultata
        return {
            "tcp_pose": tcp_pose,
            "joint_positions": joint_positions
        }

    except Exception as e:
        return {"error": str(e)}

if __name__ == "__main__":
    data = get_robot_data()
    print(json.dumps(data))  # Ispis podataka za PHP ili korisnika
